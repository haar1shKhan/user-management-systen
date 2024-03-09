<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeavePolicies;
use App\Models\LeaveEntitlement;
use App\Models\longLeave;
use Carbon\Carbon;
use App\Mail\LeaveRequestMail;
use App\Mail\LeaveStatusMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class LeaveController extends Controller
{  /**
    * Display a listing of the resource.
    */

    public $base_url = "/admin/long-leave";
    //remaing holiddays and expired holidays are not working as expected 
    //The form and the approval is working also when admin approve the total holiday is reduced

    public function index()
    {
       
        abort_if(Gate::denies('long_leave_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leave_balance = array();
        $leaveEntitlement= LeaveEntitlement::where('user_id',auth()->user()->id)->whereYear("leave_year",Carbon::now()->year)->with("policy","user")->get();
        $longLeave= longLeave::where('user_id',auth()->user()->id)->with("entitlement","approvedBy","user")->orderBy('id', 'desc')->get();
        $last_month = Carbon::now()->month-1;

        foreach ($leaveEntitlement as $key => $value) {

            $leaves = longLeave::where('entitlement_id', $value->id)->where('user_id',auth()->user()->id)->where('approved',1)->get();

            if ($value->policy->monthly) { 
                
                $leaves_subMonth = longLeave::where('entitlement_id', $value->id)
                ->where('user_id',auth()->user()->id)
                ->where(function ($query) {
                    $query->whereYear('from', Carbon::now()->year)
                        ->whereBetween(DB::raw('MONTH(`from`)'),[1,Carbon::now()->month-1]);
                })
                ->where('approved',1)->get();

                $leave_taken = 0;
                foreach ($leaves_subMonth as $index => $leave) {
                    $fromDate =Carbon::parse($leave->from);
                    $toDate =Carbon::parse($leave->to);
                    $leave_taken += $fromDate->diffInDays($toDate);
                }
               
                $expired = ($value->days/12) * $last_month - $leave_taken;
                $remaining = ($value->days - $value->leave_taken) - $expired;
            }else{
                $remaining = $value->days - $value->leave_taken;
                $expired = 0;
            }

            $leave_balance[$key]['leaveYear'] = $value->leave_year;
            $leave_balance[$key]['leaveType'] = $value->policy->title;
            $leave_balance[$key]['totaDays'] = $value->days;
            $leave_balance[$key]['leaveTaken'] = $value->leave_taken;
            $leave_balance[$key]['remainingLeave'] = $remaining;
            $leave_balance[$key]['expiredLeave'] = $expired;
           
        }
       
       $page_title = 'Request For Leave';
       $trash = false;
       $data['page_title']=$page_title;
       $data['longLeave']=$longLeave;
       $data['lastMonth']=$last_month;
       $data['entitlmentArray']=$leave_balance; //will be used for calculation
       $data['leaveEntitlement']=$leaveEntitlement; //will be used for calculation
       $data['trash']=$trash;
       $data['url']='longLeave';

       return view('admin.longLeave.index',$data);
   }



   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {       

    abort_if(Gate::denies('long_leave_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 
    $validation = $request->validate([
        'startDate' => 'required',
        'endDate' => 'required',
        'policy_id' => 'required',
        'comment' => 'required',
    ]);

    $startDate = Carbon::parse($request->input('startDate'));
    $endDate = Carbon::parse($request->input('endDate'));
    $numberOfDays = $startDate->diffInDays($endDate);
    $currentMonth = Carbon::now()->month;
    $year = $startDate->year;
    $month = $startDate->month;
    $fileName ="";

    if ($startDate->gt($endDate)) {
        $statusMessage = 'Start date cannot be after End date, please Insert Correct input.';
        return redirect($this->base_url)->with('status', $statusMessage);
    }

    if ($startDate->eq($endDate)) {
        $statusMessage = 'Cannot have holiday on same date';
        return redirect($this->base_url)->with('status', $statusMessage);
    }

    $userEntitlement = LeaveEntitlement::where('user_id',auth()->user()->id)->where('leave_policy_id', $request->input('policy_id'))->with("policy","user")->first();

     $existingLeave = longLeave::where('user_id', auth()->user()->id)
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('from', [$startDate, $endDate])
                  ->orWhereBetween('to', [$startDate, $endDate])
                  ->orWhere(function ($query) use ($startDate, $endDate) {
                      $query->where('from', '<', $startDate)
                            ->where('to', '>', $endDate);
                  });
        })
        ->get(); // Use get() to retrieve multiple overlapping records

    if ($existingLeave->count() > 0) {
        $overlappingDates = $existingLeave->pluck('from', 'to')->toArray();

        $statusMessage = 'You have overlapping leave dates on ';
        foreach ($overlappingDates as $toDate => $fromDate) {
            $statusMessage .= "{$fromDate} to {$toDate}, ";
        }
        $statusMessage = rtrim($statusMessage, ', '); // Remove trailing comma and space

        return redirect($this->base_url)->with('status', $statusMessage);
    }

    if ($userEntitlement->policy->monthly == 1) {

        if($month !== $currentMonth){
            $statusMessage = 'Cannot apply leave for comming month in advance';
            return redirect($this->base_url)->with('status', $statusMessage);
        }

    // Check if the user has already applied for leave in the current month
    // Check if leave already exists for the same user and entitlement in the same month
    $existingLeave = longLeave::where('user_id', auth()->user()->id)
    ->where('entitlement_id', $userEntitlement->id)
    ->where(function ($query) use ($year, $month) {
        $query->whereYear('from', $year)
            ->whereMonth('from', $month)
            ->orWhere(function ($query) use ($year, $month) {
                $query->whereYear('to', $year)
                    ->whereMonth('to', $month);
            });
    })
    ->get();

    
    if($existingLeave->count() > 0){
        $totalLeave=$numberOfDays;

        foreach($existingLeave as $leave){  
            //Check if the user have monthly holiday available.
            $leaveStartDate =  Carbon::parse($leave->from);
            $leaveEndDate = Carbon::parse($leave->to);
            $totalLeave += $leaveStartDate->diffInDays($leaveEndDate);
            if($totalLeave > 3){
    
                $statusMessage = "You have already used your leave for this month" ;
                return redirect($this->base_url)->with('status', $statusMessage);

            }
        }
        
        // dd($totalLeave);
        
    }

     if ($numberOfDays > 3) {
         // Handle exceeding the maximum limit (e.g., return an error response)
         $statusMessage = "Cannot take leave more than monthly set limit";
          return redirect($this->base_url)->with('status', $statusMessage);
     }

    }

    //check if the days are available for applying holidays.
    $days = $userEntitlement->days?$userEntitlement->days:$userEntitlement->policy->days;
    $remainingDays = $days - $userEntitlement->leave_taken; 

    if($remainingDays < $numberOfDays){
        $statusMessage = "You have exceeded the limit";
        return redirect($this->base_url)->with('status', $statusMessage);
    }

    if($request->leave_file)
    {
        $fileName =  now()->timestamp * 1000 . '.' . $request->leave_file->extension();
        // $fileName = time() . '.' . $request->image->extension();
        $request->file('leave_file')->storeAs('public/leave_files', $fileName);
     }

    longLeave::create([

        'user_id' => auth()->user()->id,
        'entitlement_id' => $userEntitlement->id,
        'from' => $startDate,
        'to' => $endDate,
        'number_of_days' => $numberOfDays,
        "leave_file"=> $fileName,
        "salary"=> $request->has('advance_salary'),
        'reason' => $request->input("comment"),
        // Other leave-related data
    ]);

    $data =[
        "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
        'leave_type' => $userEntitlement->policy->title,
        'start_date' => date("d/m/Y", strtotime($startDate)),
        'end_date' => date("d/m/Y", strtotime($endDate)),
        'days' =>   $numberOfDays.' days',
        'reason' => $request->input("comment"),
    ];

    Mail::to(config('settings.store_email'))->queue(new LeaveRequestMail($data));

    return redirect($this->base_url);

   }


   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
       //
    //    dd($request->all());
       abort_if(Gate::denies('long_leave_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       $validation = $request->validate([
        'startDate' => 'required',
        'endDate' => 'required',
        'comment' => 'required',
        ]);

       $longLeave= longLeave::findOrFail($id);
       $userEntitlement = LeaveEntitlement::where('user_id',$longLeave->user->id)->where('leave_policy_id',$longLeave->entitlement->policy->id)->with("policy")->first();
    //    dd($userEntitlement);
       $startDate = Carbon::parse($request->input('startDate'));
       $endDate = Carbon::parse($request->input('endDate'));
       $numberOfDays = $startDate->diffInDays($endDate);
       $currentMonth = Carbon::now()->month;
       $year = $startDate->year;
       $month = $startDate->month;
       $fileName ="";

       if ($startDate->gt($endDate)) {
        $statusMessage = 'Start date cannot be after End date, please Insert Correct input.';
        return redirect($this->base_url)->with('status', $statusMessage);
       }
   
       if ($startDate->eq($endDate)) {
           $statusMessage = 'Cannot have holiday on same date';
           return redirect($this->base_url)->with('status', $statusMessage);
       }
   
       if($month !== $currentMonth){
           $statusMessage = 'Cannot apply leave for comming month in advance';
           return redirect($this->base_url)->with('status', $statusMessage);
       }

       if ($userEntitlement->policy->monthly == 1) {

        // Check if the user has already applied for leave in the current month
        // Check if leave already exists for the same user and entitlement in the same month
        $existingLeave = longLeave::where('user_id', auth()->user()->id)
        ->where('entitlement_id', $userEntitlement->id)
        ->where(function ($query) use ($year, $month) {
            $query->whereYear('from', $year)
                ->whereMonth('from', $month)
                ->orWhere(function ($query) use ($year, $month) {
                    $query->whereYear('to', $year)
                        ->whereMonth('to', $month);
                });
        })
        ->get();
    
        
        $totalLeave=0;
        if($existingLeave->count() > 0){
    
            foreach($existingLeave as $leave){  
                //Check if the user have monthly holiday available.
                $leaveStartDate =  Carbon::parse($leave->from);
                $leaveEndDate = Carbon::parse($leave->to);
                $totalLeave += $leaveStartDate->diffInDays($leaveEndDate);
                if($totalLeave >= 3){
        
                    // dd($totalLeave);
                    $statusMessage = "You have already used your leave for this month" ;
                    return redirect($this->base_url)->with('status', $statusMessage);
    
                }
            }
        }
    
         if ($numberOfDays > 3) {
             // Handle exceeding the maximum limit (e.g., return an error response)
             $statusMessage = "Cannot take leave more than monthly set limit";
              return redirect($this->base_url)->with('status', $statusMessage);
         }
    
        }

            //check if the days are available for applying holidays.
        $days = $userEntitlement->days?$userEntitlement->days:$userEntitlement->policy->days;
        $remainingDays = $days - $userEntitlement->leave_taken; 

        if($remainingDays < $numberOfDays){
            $statusMessage = "You have exceeded the limit";
            return redirect($this->base_url)->with('status', $statusMessage);
        }

        if($request->leave_file)
        {
            $fileName =  now()->timestamp * 1000 . '.' . $request->leave_file->extension();
            // $fileName = time() . '.' . $request->image->extension();
            $request->file('leave_file')->storeAs('public/leave_files', $fileName);
         }

         $longLeave->update([
            'from' => $startDate,
            'to' => $endDate,
            'number_of_days' => $numberOfDays,
            "leave_file"=> $fileName,
            'reason' => $request->input("comment"),
         ]);

       return redirect($this->base_url);

   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
       //
       abort_if(Gate::denies('long_leave_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       longLeave::find($id)->delete();
       return redirect($this->base_url);

   }

    public function massAction(Request $request)
    {
        abort_if(Gate::denies('long_leave_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $massAction = $request['massAction'];

        foreach ($massAction as $id) {
            
            longLeave::find($id)->delete();

        }
        return redirect($this->base_url);

    }

    /**
    * Updtate Status to Approved.
    */
    public function approve(longLeave $leave){

        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($leave->approved==1){
            return redirect()->route('admin.leave.requests');
        }
        
        $startDate = Carbon::parse($leave->from);
        $endDate = Carbon::parse($leave->to);
        $numberOfDays = $startDate->diffInDays($endDate);

        $userEntitlement = LeaveEntitlement::findOrFail($leave->entitlement_id);

        $totalDays = $userEntitlement->leave_taken + $numberOfDays;
        $userEntitlement->update(['leave_taken'=>$totalDays]);

        $leave->update([
            'approved' => 1,
            'approved_by' => auth()->user()->id,
        ]);

        $this->sendEmail($leave, $userEntitlement, $numberOfDays, 'Approved');

        return redirect()->route('admin.leave.requests');
    }

    /**
    * Updtate Status to Rejected.
    */
    public function reject(Request $request, longLeave $leave){

        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($leave->approved == -1){
            return redirect()->route('admin.leave.requests');
        }

        $startDate = Carbon::parse($leave->from);
        $endDate = Carbon::parse($leave->to);
        $numberOfDays = $startDate->diffInDays($endDate);

        $userEntitlement = LeaveEntitlement::findOrFail($leave->entitlement_id);

        if($leave->approved == 1){
            $totalDays = $userEntitlement->leave_taken - $numberOfDays;
            $userEntitlement->update(['leave_taken'=>$totalDays]);
        }

        $leave->update([
            'approved' => -1,
            'reject_reason' => $request->input('reject_reason'),
            'approved_by' => auth()->user()->id,
        ]);

        $this->sendEmail($leave, $userEntitlement, $numberOfDays, 'Rejected');

        return redirect()->route('admin.leave.requests');
    }

    /**
    * Updtate Status to Pending.
    */
    public function pending(longLeave $leave){

        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($leave->approved == 0){
            return redirect()->route('admin.leave.requests');
        }
        
        $startDate = Carbon::parse($leave->from);
        $endDate = Carbon::parse($leave->to);
        $numberOfDays = $startDate->diffInDays($endDate);

        $userEntitlement = LeaveEntitlement::findOrFail($leave->entitlement_id);

        if($leave->approved == 1){
            $totalDays = $userEntitlement->leave_taken - $numberOfDays;
            $userEntitlement->update(['leave_taken'=>$totalDays]);
        }

        $leave->update([
            'approved' => 0,
            'approved_by' => null,
        ]);

        $this->sendEmail($leave, $userEntitlement, $numberOfDays, 'set to Pending');

        return redirect()->route('admin.leave.requests');
    }

    public function sendEmail($leave, $entitlement, $numberOfDays, $status){

        $data = [
            'username' => $leave->user->first_name.' '.$leave->user->last_name,
            'status'  => $status,
            'leave_type' => $entitlement->policy->title,
            'approved_by' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'duration' => $numberOfDays,
            'from' => date('d/m/Y', strtotime($leave->from)),
            'to' => date('d/m/Y', strtotime($leave->to)),
        ];
    
        Mail::to($leave->user->email)->send(new LeaveStatusMail($data));
    }
    
}



// 12 days (0+2+3+0) (0+0+0+3)