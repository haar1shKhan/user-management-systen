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
        $data['page_title'] = 'Leave Setting';
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
        //

        // dd($request->has('advance_salary'));

        $leavePolicy = new LeavePolicies([
            'title' => $request->input('title'),
            'days' => $request->input('days'),
            "monthly" => $request->has('monthly'), // true if checked, false if unchecked
            "advance_salary" => $request->has('advance_salary'), // true if checked, false if unchecked
            'roles' => $request->input('role'),
            'gender' => $request->input('gender'),
            'marital_status' => $request->input('marital_status'),
            'activate' => $request->input('activate'),
            'apply_existing_users' => $request->has('existing_user'),
        ]);

        // Save the leave policy
     

        $leavePolicy->save();

        if($request->has('existing_user')){
            $users = User::all();
            foreach($users as $user){
                LeaveEntitlement::create([
                    'leave_policy_id' => $leavePolicy->id,
                    'leave_year' => "current",
                    'days' => $request->input('days'),
                    'user_id' => $user->id,
                ]);
            }
        }

        return redirect("admin/leaveSettings/policies");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $leavePolicies = LeavePolicies::findOrFail($id);
          
        $leavePolicies->update([
            'title' => $request->input('title'),
            'days' => $request->input('days'),
            "monthly" => $request->has('monthly'), // true if checked, false if unchecked
            "advance_salary" => $request->has('advance_salary'), // true if checked, false if unchecked
            'roles' => $request->input('role'),
            'gender' => $request->input('gender'),
            'marital_status' => $request->input('marital_status'),
            'activate' => $request->input('activate'),
            'apply_existing_users' => $request->has('existing_user'),
        ]);

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
