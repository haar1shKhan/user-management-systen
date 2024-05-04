<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Profile;
use App\Models\JobDetail;
use App\Models\LeavePolicies;
use App\Models\LeaveEntitlement;
use App\Models\longLeave;
use App\Models\ShortLeave;
use App\Models\LateAttendance;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')->get();
        $data['trash'] = false;
        
        if ($request->get('trash')){
            $users = User::with('roles')->onlyTrashed()->get();
            $data['trash'] = true;
        }
        
        $data['page_title'] = 'Users';
        $data['users'] = $users;

        return view('admin.users.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();
        $supervisors = User::all();

        $data['roles'] = $roles;
        $data["supervisors"] = $supervisors;

        return view('admin/users/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required | email |unique:users',
            'phone' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
            'role' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'nationality' => 'required',
            'hired_at' => 'required',
            'joined_at' => 'required',
            'job_type' => 'required',
            'status' => 'required',
            'salary' => 'required',
            'supervisor_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'payment_method' => 'required',
        ]);

        $user = new User([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'), //
            'password' => Hash::make($request->input('password')),
        ]);
        
        $user->save();

        $user->roles()->sync([$request->input('role')]);

        if($request->image){
            $fileName = $user->id . '.' . $request->image->extension();
            $request->file('image')->storeAs('public/profile_images', $fileName);
        }

        if($request->passport_file){
            $PassportFile = $user->id . '.' . $request->passport_file->extension();
            $request->file('passport_file')->storeAs('public/passport_files', $PassportFile);
        }

        if($request->nid_file){
            $nidFile = $user->id . '.' . $request->nid_file->extension(); 
            $request->file('nid_file')->storeAs('public/nid_files', $nidFile);
        }

        if($request->visa_file){
            $visaFile = $user->id . '.' . $request->visa_file->extension(); 
            $request->file('visa_file')->storeAs('public/visa_files', $visaFile);
        }

        $profile = new Profile([
            'image' => $fileName ?? null,
            'email' => $request->input('personal_email'),
            'phone' => $request->input('phone'),
            'mobile' => $request->input('mobile'),
            'date_of_birth' => date("Y-m-d",strtotime($request->input('date_of_birth'))),
            'gender' => $request->input('gender'),
            'nationality' => $request->input('nationality'),
            'marital_status' => $request->input('marital_status'),
            'biography' => $request->input('biography'),
            'religion' => $request->input('religion'),
            'address' => $request->input('address'),
            'address2' => $request->input('address2'),
            'city' => $request->input('city'),
            'province' => "Null",
            'passport' => $request->input('passport'),
            'passport_issued_at' => $request->input('passport_issued_at'),
            'passport_expires_at' => $request->input('passport_expires_at'),
            'passport_file' => $request->passport_file ?? null,
            'nid' => $request->input('nid'),
            'nid_issued_at' => $request->input('nid_issued_at'),
            'nid_expires_at' => $request->input('nid_expires_at'),
            'nid_file' => $nidFile ?? null,
            'visa' => $request->input('visa'),
            'visa_issued_at' => $request->input('visa_issued_at'),
            'visa_expires_at' => $request->input('visa_expires_at'),
            'visa_file' => $request->visa_file ?? null,
            'country' => $request->input('country'),
        ]);
        
        //  Save the profile data and associate it with the user
        $user->profile()->save($profile);

        $joining_date = strtotime($request->input('joined_at'));
        $end_year = date('Y-m-d',strtotime('+1 year',$joining_date));

        $jobDetail = new JobDetail([
            'hired_at' => date("Y-m-d",strtotime($request->input('hired_at'))),
            'joined_at' => date("Y-m-d",$joining_date),
            'resigned_at' => date("Y-m-d",strtotime($request->input('resigned_at'))),
            'start_year' => date("Y-m-d",$joining_date),
            'end_year' => $end_year,
            'source_of_hire' => $request->input('source_of_hire'),
            'job_type' => $request->input('job_type'),
            'status' => $request->input('status'),
            'salary' => $request->input('salary'),
            'iban' => $request->input('iban'),
            'bank_name' => $request->input('bank_name'),
            'bank_account_number' => $request->input('bank_account_number'),
            'payment_method' => $request->input('payment_method'),
            // 'recived_email_notification' => $request->input('recived_email_notification') ?? false,
            'user_id' => $user->id,
            'supervisor_id' => $request->input('supervisor_id'), // Assuming supervisor is a user ID
        ]);
    
        $jobDetail->save();

        $current_date = new DateTime("now", new DateTimeZone("Asia/Dubai"));
        $end_year = date('Y-m-d',strtotime($user->jobDetail->end_year));

        while($end_year <= $current_date->format('Y-m-d')){
            $user->jobDetail->start_year = $end_year;
            $user->jobDetail->end_year = date('Y-m-d',strtotime('+1 year',strtotime($user->jobDetail->end_year)));
            $user->jobDetail->save();
            $end_year = $user->jobDetail->end_year;
        }
        // policies immidiatly after hiring

        $leave_policies = LeavePolicies::where('activate','=','immediately_after_hiring')->get();

        if (count($leave_policies) > 0){
            foreach ($leave_policies as $key => $value) {

                $role = $value->roles;
                $gender = $value->gender;
                $marital_status = $value->marital_status;
                $user_role = Role::find($request->input('role'));

                if ($role === NULL) {
                    $role = $user_role->title;
                    
                }
                if ($gender === NULL) {
                    $gender = $user->profile->gender;
                    
                }
                if ($marital_status === NULL) {
                    $marital_status = $user->profile->marital_status;
                }
                
                if( $role == $user_role->title and $gender == $user->profile->gender and $marital_status == $user->profile->marital_status){
                    LeaveEntitlement::create(
                        [
                            'leave_policy_id' => $value->id,
                            'start_year' => $user->jobDetail->start_year,
                            'end_year' => $user->jobDetail->end_year,
                            'days' => $value->days ,
                            'user_id' => $user->id,
                        ]
                    );
                    
                }
            }
        }

        $mailData = [
            'name' => $user->first_name.' '.$user->last_name,
            'email' => $user->email,
            'joining_date' => date("d/m/Y",$joining_date),
        ];

        Mail::to($user->email)->queue(new WelcomeMail($mailData));
    
        return redirect('admin/users');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles','profile','jobDetail')->find($id);
        $longLeave= longLeave::where('user_id',$id)->with("entitlement","approvedBy","user")->orderBy('id', 'desc')->get();
        $shortLeave= ShortLeave::where('user_id',$id)->with("approvedBy","user")->orderBy('id', 'desc')->get();
        $lateAttendance= LateAttendance::where('user_id',$id)->with("approvedBy","user")->orderBy('id', 'desc')->get();
        $leaveEntitlement= LeaveEntitlement::where('user_id',$id) ->orderBy('leave_policy_id', 'desc')->get();
        $last_month = Carbon::now()->month-1;
        $policies= LeavePolicies::all();

        $current_date = new DateTime("now", new DateTimeZone("Asia/Dubai"));

        $end_year = date('Y/m/d', strtotime('+1 year', strtotime($user->jobDetail->joined_at))); //2018 - 2019
        $employee_years = [date('Y/m/d', strtotime($user->jobDetail->joined_at)).'-'.date('Y/m/d', strtotime($end_year))]; //2018 - 2019


        while ($end_year <= $current_date->format('Y/m/d')) {
            $start_year = $end_year;
            $end_year = date('Y/m/d', strtotime('+1 year', strtotime($end_year)));
            $employee_years[] = $start_year.'-'.$end_year; 
        }

        
        // dd($employee_year);
        $data['page_title'] = 'User Detail';
        $data['user'] = $user;
        $data['longLeave'] = $longLeave;
        $data['shortLeave'] = $shortLeave;
        $data['lateAttendance'] = $lateAttendance;
        $data['leaveEntitlement'] = $leaveEntitlement;
        $data['employee_years'] = $employee_years;
        $data['policies'] = $policies;
        $data['lastMonth'] = $last_month;

        $data['url'] = 'user';

        return view('admin/users/show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user=User::with('roles')->findOrFail($id);
        $supervisors = User::all();

        $roles = Role::all();
        
        if(is_null($user))
        {
            return redirect('user');
        }
        $data = compact('user','roles','supervisors');
      
        return view('admin/users/edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
            $user = User::findOrFail($id);

            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'role' => 'required',
                'date_of_birth' => 'required',
                'gender' => 'required',
                'marital_status' => 'required',
                'nationality' => 'required',
                'hired_at' => 'required',
                'joined_at' => 'required',
                'job_type' => 'required',
                'status' => 'required',
                'salary' => 'required',
                'supervisor_id' => 'required',
                'address' => 'required',
                'city' => 'required',
                'country' => 'required',
                'payment_method' => 'required',
            ]);
          
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'), //
            ]);


        if ($request->hasFile('image')) {
            $fileName = $user->id . '.' . $request->image->extension();
            $request->file('image')->storeAs('public/profile_images', $fileName);

            $user->profile->update([
                'image' => $fileName,
            ]);
        }

        if ($request->hasFile('passport_file')) {
            $fileName = $user->id . '.' . $request->passport_file->extension();
            $request->file('passport_file')->storeAs('public/passport_files', $fileName);

            $user->profile->update([
                'passport_file' => $fileName,
            ]);
        }
        if ($request->hasFile('nid_file')) {
            $fileName = $user->id . '.' . $request->nid_file->extension();
            $request->file('nid_file')->storeAs('public/nid_files', $fileName);

            $user->profile->update([
                'nid_file' => $fileName,
            ]);
        }
        if ($request->hasFile('visa_file')) {
            $fileName = $user->id . '.' . $request->visa_file->extension();
            $request->file('visa_file')->storeAs('public/visa_files', $fileName);
    
            $user->profile->update([
                'visa_file' => $fileName,
            ]);
        }    

        $user->profile->update([
            'email' => $request->input('personal_email'),
            'phone' => $request->input('phone'),
            'mobile' => $request->input('mobile'),
            'date_of_birth' => date("Y-m-d",strtotime($request->input('date_of_birth'))),
            'gender' => $request->input('gender'),
            'nationality' => $request->input('nationality'),
            'marital_status' => $request->input('marital_status'),
            'biography' => $request->input('biography'),
            'religion' => $request->input('religion'),
            'address' => $request->input('address'),
            'address2' => $request->input('address2'),
            'city' => $request->input('city'),
            'province' => "Null",
            'passport' => $request->input('passport'),
            'passport_issued_at' => $request->input('passport_issued_at'),
            'passport_expires_at' => $request->input('passport_expires_at'),
            'nid' => $request->input('nid'),
            'nid_issued_at' => $request->input('nid_issued_at'),
            'nid_expires_at' => $request->input('nid_expires_at'),
            'visa' => $request->input('visa'),
            'visa_issued_at' => $request->input('visa_issued_at'),
            'visa_expires_at' => $request->input('visa_expires_at'),
            'country' => $request->input('country'),
        ]);

        $joining_date = strtotime($request->input('joined_at'));
        $end_year = date('Y-m-d',strtotime('+1 year',$joining_date));

        $user->jobDetail->update([
            'hired_at' => $request->input('hired_at'),
            'joined_at' => date("Y-m-d",$joining_date),
            'resigned_at' => $request->input('resigned_at'),
            'start_year' => date("Y-m-d",$joining_date),
            'end_year' => $end_year,
            'source_of_hire' => $request->input('source_of_hire'),
            'job_type' => $request->input('job_type'),
            'status' => $request->input('status'),
            'salary' => $request->input('salary'),
            'iban' => $request->input('iban'),
            'bank_name' => $request->input('bank_name'),
            'bank_account_number' => $request->input('bank_account_number'),
            'payment_method' => $request->input('payment_method'),
            'supervisor_id' => $request->input('supervisor_id'), 
        ]);

        $current_date = new DateTime("now", new DateTimeZone("Asia/Dubai"));
        $end_year = date('Y-m-d',strtotime($user->jobDetail->end_year));

        while($end_year <= $current_date->format('Y-m-d')){
            $user->jobDetail->start_year = $end_year;
            $user->jobDetail->end_year = date('Y-m-d',strtotime('+1 year',strtotime($user->jobDetail->end_year)));
            $user->jobDetail->save();
            $end_year = $user->jobDetail->end_year;
        }

        $user->roles()->sync([$request->input('role')]);

        return redirect('admin/users');       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        User::find($id)->delete();
        return redirect('admin/users');

    }

    public function massAction(Request $request)
    {
        $massAction = $request['massAction'];
        $actionType = $request['action_type'];
        
        if($actionType == 'restoreAll'){

            foreach ($massAction as $id) {

            User::withTrashed()->find($id)->restore();
            
            }
            return redirect('admin/users?trash=1');
        }

        if($actionType == 'forceDestroyAll'){

        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
            foreach ($massAction as $id) {

                User::withTrashed()->find($id)->forceDelete();
                
            }
            return redirect('admin/users?trash=1');
            
        }
        
        if($actionType == 'destroyAll'){

        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            
            foreach ($massAction as $id) {
                
                User::find($id)->delete();
            }
            return redirect('admin/users');
        }

        return redirect('admin/users');
    }

    public function restore(string $id)
    {
        User::withTrashed()->find($id)->restore();
        return redirect('admin/users?trash=1');
    }
 
    public function forceDelete(string $id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::withTrashed()->find($id)->forceDelete();
        return redirect('admin/users?trash=1');
    }


    public function storeLongLeave(Request $request, string $id)
    {       
    //    dd($request->all()); 
     abort_if(Gate::denies('long_leave_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
     $validation = $request->validate([
         'startDate' => 'required',
         'endDate' => 'required',
         'entit_id' => 'required',
     ]);
 
     $startDate = Carbon::parse($request->input('startDate'));
     $endDate = Carbon::parse($request->input('endDate'));
     $numberOfDays = $startDate->diffInDays($endDate) + 1;
     $year = $startDate->year;
     $month = $startDate->month;
     $fileName ="";
 
     if ($startDate->gt($endDate)) {
         $statusMessage = 'Start date cannot be after End date, please Insert Correct input.';
         return redirect()->back()->with('status', $statusMessage);
     }

     
     $userEntitlement = LeaveEntitlement::where('user_id',$id)->where("id",$request->input('entit_id'))
     ->with("policy","user")->first();

    $allUserEntitlement = LeaveEntitlement::where('user_id',auth()->user()->id)->where('leave_policy_id', $userEntitlement->policy->id)->with("policy","user")->get();



      $existingLeave = longLeave::where('user_id', $id)
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
 
         return redirect()->back()->with('status', $statusMessage);
     }
 
     if ($userEntitlement->policy->monthly == 1) {
 
        //  if($month !== $currentMonth){
        //      $statusMessage = 'Cannot apply leave for comming month in advance';
        //      return redirect()->back()->with('status', $statusMessage);
        //  }
 
     // Check if the user has already applied for leave in the current month
     // Check if leave already exists for the same user and entitlement in the same month
     $existingLeave = longLeave::where('user_id', $id)
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
                 return redirect()->back()->with('status', $statusMessage);
 
             }
         }
         
         // dd($totalLeave);
         
     }
 
      if ($numberOfDays > 3) {
          // Handle exceeding the maximum limit (e.g., return an error response)
          $statusMessage = "Cannot take leave more than monthly set limit";
           return redirect()->back()->with('status', $statusMessage);
      }
 
     }
 
     //check if the days are available for applying holidays.
     $days = 0;
     $leave_taken = 0;
 
     foreach ($allUserEntitlement as $balance) { // Note the "&" before $balance to make it a reference
           $days += $balance->days;
           $leave_taken += $balance->leave_taken;
     }
     
     $remainingDays = $days - $leave_taken; 
     dd($remainingDays,$numberOfDays);
     if($remainingDays < $numberOfDays){
         $statusMessage = "You have exceeded the limit";
         return redirect()->back()->with('status', $statusMessage);
     }
 
     if($request->leave_file)
     {
         $fileName =  now()->timestamp * 1000 . '.' . $request->leave_file->extension();
         // $fileName = time() . '.' . $request->image->extension();
         $request->file('leave_file')->storeAs('public/leave_files', $fileName);
      }

      $totalDays = $userEntitlement->leave_taken + $numberOfDays;
      $userEntitlement->update(['leave_taken'=>$totalDays]);
 
     longLeave::create([
         'user_id' => $id,
         'entitlement_id' => $userEntitlement->id,
         'from' => $startDate,
         'to' => $endDate,
         'approved' => 1,
         'approved_by' =>  auth()->user()->id,
         'number_of_days' => $numberOfDays,
         "leave_file"=> $fileName,
         "salary"=> $request->has('advance_salary'),
         'reason' => $request->input("comment"),
         // Other leave-related data
     ]);
 
 
     return redirect()->back();
 
    }

    public function storeEntitlement(Request $request, string $id){

        // dd($request->all());
        
        $leavePolicies = LeavePolicies::find($request->input('policy_id'));
        $days = $request->input('days');
        $dates = explode('-', $request->input('entitlement_year'));
        $userEntitlement = LeaveEntitlement::where('user_id',$id)->where('leave_policy_id', $request->input('policy_id'))
        ->where('start_year', $dates[0])
        ->where('end_year',  $dates[1])
        ->with("policy","user")->first();
         
        
     if(!empty($userEntitlement)){
        $statusMessage = 'This Entitlement : '.$userEntitlement->policy->title." - ".date('M Y',strtotime($userEntitlement->start_year))." to ".date('M Y',strtotime($userEntitlement->end_year)).' Already exist';
        return redirect()->back()->with("status",$statusMessage);
     }
            if($leavePolicies->monthly){
                if($days > 31){
                    $statusMessage = 'You cannot choose more than 31 days ';
                    return redirect()->back()->with("status",$statusMessage);
                  }
                  $days = $request->input("days") * 12;
            }
    
            $userEntitlement =  new LeaveEntitlement([
                'leave_policy_id' => $request->input('policy_id'),
                'start_year' => $dates[0],
                'end_year' => $dates[1],
                'days' =>  $request->input('days'),
                'user_id' => $id,
            ]);
            $userEntitlement->save();

            return redirect()->back();
    }

}
