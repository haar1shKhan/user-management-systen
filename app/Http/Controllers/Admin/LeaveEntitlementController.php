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
        // dd($leavePolicies);
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
          if (empty($users)) {
            return redirect('admin/leaveSettings/leaveEntitlement')->with('status','Please Choose Users');
          }
          $leavePolicies = LeavePolicies::find($request->input('leave_policy_id'));
          $days = $request->input('days');
        
          if($leavePolicies->monthly){
              if($days > 31){
                  $statusMessage = 'You cannot choose more than 31 days ';
                  return redirect()->route('admin.leaveSettings.leaveEntitlement')->with("status",$statusMessage);
                }
                $days = $request->input("days") * 12;
          }
  
          foreach($users as $user){

            $user_model = User::find($user);

            if (LeaveEntitlement::where('leave_policy_id', $request->input('leave_policy_id'))->where('user_id',$user_model->id)->where('start_year',$user_model->jobDetail->start_year)->where('end_year',$user_model->jobDetail->end_year)->exists()) {
                continue;
            }

            $leaveEntitlement = new LeaveEntitlement([
                'leave_policy_id' => $request->input('leave_policy_id'),
                'start_year' => $user_model->jobDetail->start_year,
                'end_year' => $user_model->jobDetail->end_year,
                'days' =>  $days,
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
    public function update(Request $request, LeaveEntitlement $leaveEntitlement)
    {
        abort_if(Gate::denies('leave_entitlement_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $days = $request->input('days');
        if($leaveEntitlement->policy->montly){
            if($days > 31){
                $statusMessage = 'You cannot choose more than 31 days ';
                return redirect()->route('admin.leaveSettings.leaveEntitlement')->with("status",$statusMessage);
            }
            $days = $request->input("days") * 12;
        }

        if($days != 0){
            if($days <= $leaveEntitlement->leave_taken){
                $statusMessage = 'The user already has taken '.$leaveEntitlement->leave_taken.' days leave';
                return redirect()->route('admin.leaveSettings.leaveEntitlement')->with("status",$statusMessage);
            }
        }

        $leaveEntitlement -> update([
            'days' => $days,
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
