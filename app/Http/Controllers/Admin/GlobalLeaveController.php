<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeavePolicies;
use App\Models\LeaveEntitlement;
use App\Models\ShortLeave;
use App\Models\LateAttendance;
use App\Models\longLeave;
use App\Models\User;
use Carbon\Carbon;


class GlobalLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $longLeaves = LongLeave::all();
        $shortLeave = ShortLeave::all();
        $lateAttendances = LateAttendance::all();

        $page_title = 'Leave Requests';
        $trash = false;
        $data['url']='globalLeave';

        $data['longLeaves']=$longLeaves;
        $data['shortLeave']=$shortLeave;
        $data['lateAttendances']=$lateAttendances;
        $data['page_title']=$page_title;


        return view('admin.globalLeave.index',$data);
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
        //
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

    public function update(Request $request, string $id)
    {
        //
        if(auth()->user()->roles[0]->title != "Admin"){
            return redirect('admin/globalLeave');
        }

        if($request->type=="longLeave"){


            $longLeave= longLeave::findOrFail($id);
            $userEntitlement = LeaveEntitlement::where('user_id',$longLeave->user->id)->where('leave_policy_id',$longLeave->policy_id)->with("policy")->first();
           
     
            // Check if the button clicked is for approval or rejection
            if ($request->has('approve')) {
     
                $longLeave->update(['approved' => 1]);
                $startDate = Carbon::parse($longLeave->from);
                $endDate = Carbon::parse($longLeave->to);
                $numberOfDays = $startDate->diffInDays($endDate) + 1;
     
                $totalEntitlementDays = ($userEntitlement->days != null) ? ($userEntitlement->days - $numberOfDays) : ($userEntitlement->policy->days - $numberOfDays);   
                $userEntitlement->update(['days'=>$totalEntitlementDays]);
     
     
            } elseif ($request->has('reject')) {
     
                $longLeave->update(['approved' => -1]); // Assuming 2 represents rejection, adjust as needed
                $startDate = Carbon::parse($longLeave->from);
                $endDate = Carbon::parse($longLeave->to);
                $numberOfDays = $startDate->diffInDays($endDate) + 1;
     
                $totalEntitlementDays = ($userEntitlement->days != null) ? ($userEntitlement->days + $numberOfDays) : ($userEntitlement->policy->days + $numberOfDays);   
                $userEntitlement->update(['days'=>$totalEntitlementDays]);
            }
        
            // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
            if(auth()->user()->roles[0]->title == "Admin")
            {
                $longLeave->update(['approved_by' => auth()->user()->id]);
            }
     
            return redirect("/admin/globalLeave");
     

        }
        if($request->type=="lateAttendances"){

            $lateAttendance = LateAttendance::findOrFail($id);

            // Check if the button clicked is for approval or rejection
            if ($request->has('approve')) {
                $lateAttendance->update(['approved' => 1]);
            } elseif ($request->has('reject')) {
                $lateAttendance->update(['approved' => -1]); // Assuming 2 represents rejection, adjust as needed
            }
        
            // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
            if(auth()->user()->roles[0]->title == "Admin")
            {
                $lateAttendance->update(['approved_by' => auth()->user()->id]);
            }
            // Update the field 
            if($request->reason){
            $lateAttendance->update(['reason' => $request->reason]);
            }
    
            return redirect('admin/globalLeave');
        }


        if($request->type=="shortLeave"){

            $shortLeave = ShortLeave::findOrFail($id);

            // Check if the button clicked is for approval or rejection
            if ($request->has('approve')) {
                $shortLeave->update(['approved' => 1]);
            } elseif ($request->has('reject')) {
                $shortLeave->update(['approved' => -1]); // Assuming 2 represents rejection, adjust as needed
            }
        
            // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
            if(auth()->user()->roles[0]->title == "Admin")
            {
                $shortLeave->update(['approved_by' => auth()->user()->id]);
            }
            // Update the field 
            if($request->reason){
            $shortLeave->update(['reason' => $request->reason]);
            }

            return redirect('admin/globalLeave');    

        }

    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
