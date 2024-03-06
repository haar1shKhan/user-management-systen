<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveEntitlement;
use App\Models\LeavePolicies;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class LeaveEntitlementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('leave_entitlement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveEntitlement = LeaveEntitlement::with("policy","user")->get();
        $leavePolicies = LeavePolicies::get();
        $users = User::get();

        $data['page_title'] = 'Leave Manager';
        $data['leaveEntitlement'] = $leaveEntitlement;
        $data['leavePolicies'] = $leavePolicies;
        $data['users'] = $users;
        $data['trash'] = null;
        $data['url'] = 'leaveSettings';

        return view('admin.leaveSettings.leaveEntitlement.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('leave_entitlement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
          // Create a new LeaveEntitlement instance
          $users = $request->input("user_id");

          foreach($users as $user){
            
          $leaveEntitlement = new LeaveEntitlement([
            'leave_policy_id' => $request->input('leave_policy_id'),
            'leave_year' => $request->input('leave_year'),
            'days' => $request->input('days'),
            'user_id' => $user,
        ]);

        $leaveEntitlement->save();
        }

        // Save the LeaveEntitlement instance

        return redirect('admin/leaveSettings/leaveEntitlement');
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
        abort_if(Gate::denies('leave_entitlement_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $leaveEntitlement = LeaveEntitlement::findOrFail($id);

        $leaveEntitlement -> update([
            'leave_policy_id' => $request->input('leave_policy_id'),
            'leave_year' => $request->input('leave_year'),
            'days' => $request->input('days'),
            // 'user_id' => $user,
        ]);

        return redirect('admin/leaveSettings/leaveEntitlement');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('leave_entitlement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        LeaveEntitlement::find($id)->delete();
        
        return redirect('admin/leaveSettings/leaveEntitlement');
        
    }
    
    
    public function massAction(Request $request)
    {
        abort_if(Gate::denies('leave_entitlement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $massAction = $request['massAction'];

        foreach ($massAction as $id) {
            
            LeaveEntitlement::find($id)->delete();

        }
        return redirect('admin/leaveSettings/leaveEntitlement');

    }
}
