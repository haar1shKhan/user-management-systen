<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeavePolicies;
use App\Models\LeaveEntitlement;
use App\Models\longLeave;
use Carbon\Carbon;

class LeaveController extends Controller
{  /**
    * Display a listing of the resource.
    */


    //remaing holiddays and expired holidays are not working as expected 
    //The form and the approval is working also when admin approve the total holiday is reduced

   public function index()
   {
       //
    //    $longLeaveTitle = LeavePolicies::get();
       $leaveEntitlement= LeaveEntitlement::where('user_id',auth()->user()->id)->with("policy","user")->get();
       $longLeave= longLeave::where('user_id',auth()->user()->id)->with("entitlement","approvedBy","user")->get();
    //    dd($longLeave);
       $remainingHolidays = 0;
       $expiredHolidays = 0;

       // Get the current month
       $currentMonth = Carbon::now()->month;
       

        // Check if the policy is monthly
        // if ($entitlement['policy']['monthly'] == 1) {
        //     // Calculate remaining and expired holidays for monthly policy
        //     $remainingHolidays += $totalDays - ($currentMonth * ($totalDays / 12));
        //     $expiredHolidays += ($currentMonth * ($totalDays / 12)) - $totalDays;
        // } else {
        //     // For non-monthly policy, calculate remaining and expired holidays
        //     $remainingHolidays +=  $entitlement['days'] - $totalDays ;
        //     $expiredHolidays = 0;
        // }

       $page_title = 'Leave Application';
       $trash = false;
       $data['page_title']=$page_title;
    //    $data['longLeaveTitle']=$longLeaveTitle;
       $data['longLeave']=$longLeave;
       $data['currentMonth']=$currentMonth;
       $data['leaveEntitlement']=$leaveEntitlement; //will be used for calculation
       $data['remainingHolidays']=$remainingHolidays; //will be used for calculation
       $data['expiredHolidays']=$expiredHolidays; //will be used for calculation
       $data['trash']=$trash;
       $data['url']='longLeave';

       return view('admin.LongLeave.index',$data);
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
       //
       $page_title = 'long Leave Application';
       $data['page_title']=$page_title;
       return view('admin.passportApplication.index',$data);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {    
    
    // dd($request->all());
    
    $startDate = Carbon::parse($request->input('startDate'));
    $endDate = Carbon::parse($request->input('endDate'));
    $numberOfDays = $startDate->diffInDays($endDate) + 1;
    $currentMonth = Carbon::now()->month;
    $fileName ="";

    // $leave_file = $request['leave_file'];

    // dd($leave_file);

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

        return redirect("/admin/longLeave")->with('status', $statusMessage);
    }


    
   

 

    if ($userEntitlement->policy->monthly == 1) {

        if ($numberOfDays > 3) {
            // Handle exceeding the maximum limit (e.g., return an error response)
    
            $statusMessage = "Cannot take leave more than monthly set limit";
             return redirect("/admin/longLeave")->with('status', $statusMessage);

        }

        // $validateDays = $userEntitlement->days ?? $userEntitlement->policy->days;

        $days = $userEntitlement->days?$userEntitlement->days:$userEntitlement->policy->days;
        $remainingDays = $days - $userEntitlement->leave_taken;

        $remainingDaysMonthy = $remainingDays - ($currentMonth * 3);
        

        if ($remainingDaysMonthy < $numberOfDays) {
            // Handle insufficient entitlement (e.g., return an error response)
            $statusMessage = "You have exceeded the limit";
            return redirect("/admin/longLeave")->with('status', $statusMessage);
        }

    }

    $days = $userEntitlement->days?$userEntitlement->days:$userEntitlement->policy->days;
    $remainingDays = $days - $userEntitlement->leave_taken;  
    if($remainingDays < $numberOfDays){
        $statusMessage = "You have exceeded the limit";
        return redirect("/admin/longLeave")->with('status', $statusMessage);

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
        'reason' => $request->input("comment"),
        // Other leave-related data
    ]);

    return redirect("/admin/longLeave");

   }

   /**
    * Display the specified resource.
    */
   public function show(string $id)
   {
       //
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(string $id)
   {
       //
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
       //
       $longLeave= longLeave::findOrFail($id);
       $userEntitlement = LeaveEntitlement::where('user_id',$longLeave->user->id)->where('leave_policy_id',$longLeave->policy_id)->with("policy")->first();
      

       // Check if the button clicked is for approval or rejection
       if ($request->has('approve')) {

           $longLeave->update(['approved' => 1]);
           $startDate = Carbon::parse($longLeave->from);
           $endDate = Carbon::parse($longLeave->to);
           $numberOfDays = $startDate->diffInDays($endDate) + 1;

        //    $totalEntitlementDays = ($userEntitlement->days != null) ? ($userEntitlement->days - $numberOfDays) : ($userEntitlement->policy->days - $numberOfDays);   
           if($userEntitlement->leave_taken==0){
                $userEntitlement->update(['leave_taken'=>$numberOfDays]);
           } 
           else{
                $totalDays = $userEntitlement->leave_taken + $numberOfDays;
                $userEntitlement->update(['leave_taken'=>$totalDays]);
           }


       } elseif ($request->has('reject')) {

           $startDate = Carbon::parse($longLeave->from);
           $endDate = Carbon::parse($longLeave->to);
           $numberOfDays = $startDate->diffInDays($endDate) + 1;
           //    $totalEntitlementDays = ($userEntitlement->days != null) ? ($userEntitlement->days + $numberOfDays) : ($userEntitlement->policy->days + $numberOfDays);   
           //    $userEntitlement->update(['days'=>$totalEntitlementDays]);
           $longLeave->update(['approved' => -1]); // Assuming 2 represents rejection, adjust as needed
            $totalDays = $userEntitlement->leave_taken - $numberOfDays;
            $userEntitlement->update(['leave_taken'=>$totalDays]);
       }
   
       // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
       if(auth()->user()->roles[0]->title == "Admin")
       {
           $longLeave->update(['approved_by' => auth()->user()->id]);
       }

       return redirect("/admin/longLeave");

   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
       //
       longLeave::find($id)->delete();

       return redirect('admin/longLeave');

   }

    public function massAction(Request $request)
    {
        $massAction = $request['massAction'];

        foreach ($massAction as $id) {
            
            longLeave::find($id)->delete();

        }
        return redirect('admin/longLeave');

    }
    
}
