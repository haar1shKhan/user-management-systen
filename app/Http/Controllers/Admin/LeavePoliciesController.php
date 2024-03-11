<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeavePolicies;
use App\Models\LeaveEntitlement;
use App\Models\User;
use App\Models\Role;



class LeavePoliciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $leavePolicies = LeavePolicies::get();
        $roles = Role::all();


        $data['roles']=$roles;
        $data['page_title'] = 'Leave Manager';
        $data['leavePolicies'] = $leavePolicies;
        $data['trash'] = null;
        $data['url'] = 'leaveSettings';

        return view('admin.leaveSettings.leavePolicies.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $days = $request->input('days');
        $max_days = $request->input('max_days') ?? 0;

        if($request->has('monthly')){
            if($days > 31){
                $statusMessage = 'You cannot choose more than 31 days ';
                return redirect()->route('admin.leaveSettings.leavePolicies')->with("status",$statusMessage);
            }
            $days = $request->input("days") * 12;
        }

        $leavePolicy = new LeavePolicies([
            'title' => $request->input('title'),
            'days' => $days,
            'max_days' => $max_days,
            "monthly" => $request->has('monthly'), // true if checked, false if unchecked
            "advance_salary" => $request->has('advance_salary'), // true if checked, false if unchecked
            "is_unlimited" => $request->input('is_unlimited'), // true if checked, false if unchecked
            'roles' => $request->input('role'),
            'gender' => $request->input('gender'),
            'marital_status' => $request->input('marital_status'),
            'activate' => $request->input('activate'),
        ]);

        // Save the leave policy
     

        $leavePolicy->save();


        if(!$request->has('existing_user')){
            
            return redirect("admin/leaveSettings/policies");
        }

        $users = User::with("roles","profile")->get();

        

        if (count($users) > 0){
            foreach ($users as $key => $user) {
                $gender = $request->input('gender') ;
                $role = $request->input('role') ;
                $marital_status = $request->input('marital_status');

               if(count($user->roles)>0){
                    $user_role = Role::find($user->roles[0]->id);
                }

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
                    

                    $leaveEntitlement = new LeaveEntitlement( [
                        'leave_policy_id' => $leavePolicy->id,
                        'start_year' => $user->jobDetail->start_year,
                        'end_year' => $user->jobDetail->end_year,
                        'max_days' => $leavePolicy->max_days,
                        'days' => $leavePolicy->days,
                        'user_id' => $user->id,
                    ]);

                    $leaveEntitlement->save();
                    
                }
            }
        }
        // die;
        return redirect("admin/leaveSettings/policies");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd($request->all());
        $leavePolicies = LeavePolicies::findOrFail($id);
        $days = $request->input('days');
        $max_days = $request->input('max_days');
        
        if($request->has('monthly')){
            if($days > 31){
                $statusMessage = 'You cannot choose more than 31 days ';
                return redirect()->route('admin.leaveSettings.leavePolicies')->with("status",$statusMessage);
            }
            $days = $request->input("days") * 12;
        }

        $leavePolicies->update([
            'title' => $request->input('title'),
            'days' => $days,
            'max_days' => $max_days,
            "monthly" => $request->has('monthly'), // true if checked, false if unchecked
            "advance_salary" => $request->has('advance_salary'), // true if checked, false if unchecked
            "is_unlimited" => $request->input('is_unlimited'), // true if checked, false if unchecked
            'roles' => $request->input('role'),
            'gender' => $request->input('gender'),
            'marital_status' => $request->input('marital_status'),
            'activate' => $request->input('activate'),
        ]);


        if(!$request->has('existing_user')){
            
            return redirect("admin/leaveSettings/policies");

        }

        // if the existing_user is true apply all the valid policies
        $users = User::with("roles","profile")->get();
        
        if (count($users) > 0){
            foreach ($users as $key => $user) {
            
                if  (LeaveEntitlement::where('leave_policy_id',$id)
                        ->where('user_id',$user->id)
                        ->where('start_year',$user->jobDetail->start_year)
                        ->where('end_year',$user->jobDetail->end_year)->exists()) 
                {
                    continue;
                }
              
                $gender = $request->input('gender') ;
                $role = $request->input('role') ;
                $marital_status = $request->input('marital_status');

               if(count($user->roles)>0){
                    $user_role = Role::find($user->roles[0]->id);
                }

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
                    
                    $leaveEntitlement = new LeaveEntitlement( [
                        'leave_policy_id' => $leavePolicies->id,
                        'start_year' => $user->jobDetail->start_year,
                        'end_year' => $user->jobDetail->end_year,
                        'max_days' => $leavePolicies->max_days,
                        'days' => $leavePolicies->days,
                        'user_id' => $user->id,
                    ]);

                    $leaveEntitlement->save();
                    
                }
            }
        }
        // die;

        return redirect("admin/leaveSettings/policies");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        LeavePolicies::find($id)->delete();
        return redirect('admin/leaveSettings/policies');
    }

    public function massAction(Request $request)
    {
        $massAction = $request['massAction'];

        foreach ($massAction as $id) {
            
            LeavePolicies::find($id)->delete();
        }
        return redirect('admin/leaveSettings/policies');

    }
}
