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
            $userEntitlement = LeaveEntitlement::where('user_id',$longLeave->user->id)->where('leave_policy_id',$request["leave_policy_id"])->with("policy")->first();
            $startDate = Carbon::parse($longLeave->from);
            $endDate = Carbon::parse($longLeave->to);
            $numberOfDays = $startDate->diffInDays($endDate) + 1;
           
            // dd($request->all());
            // dd($userEntitlement->leave_taken);
            
            // Check if the button clicked is for approval or rejection
            if ($request->has('approve')) {
     
               
                
                if($userEntitlement->leave_taken==0){
                    
                    $userEntitlement->update(['leave_taken'=> $numberOfDays]);
                    $longLeave->update(['approved' => 1]);

                } 
                else{
                    
                    $totalDays = $userEntitlement->leave_taken + $numberOfDays;
                    $userEntitlement->update(['leave_taken'=>$totalDays]);
                    $longLeave->update(['approved' => 1]);

               }
     
     
            } elseif ($request->has('reject')) {

                if($longLeave->approved==1){
                    $totalDays = $userEntitlement->leave_taken - $numberOfDays;
                    $userEntitlement->update(['leave_taken'=>$totalDays]);
                }
                
                $longLeave->update(['approved' => -1]); // Assuming 2 represents rejection, adjust as needed
            }
            
            // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
            if(auth()->user()->roles[0]->title == "Admin" && !$request->has('pending') )
            {
                $longLeave->update(['approved_by' => auth()->user()->id]);
                return redirect("/admin/globalLeave");
            }
            
            if($longLeave->approved==1){
                $totalDays = $userEntitlement->leave_taken - $numberOfDays;
                $userEntitlement->update(['leave_taken'=>$totalDays]);
            }
            $longLeave->update(['approved_by' => null]);
            $longLeave->update(['approved' => 0]); 
            

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
            if(auth()->user()->roles[0]->title == "Admin"  && !$request->has('pending')  )
            {
                $lateAttendance->update(['approved_by' => auth()->user()->id]);
                return redirect('admin/globalLeave');
            }
            // Update the field 
            if($request->reason){
            $lateAttendance->update(['reason' => $request->reason]);
            }

            $lateAttendance->update(['approved_by' => null]);
            $lateAttendance->update(['approved' => 0]); 

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
            if(auth()->user()->roles[0]->title == "Admin"  && !$request->has('pending'))
            {
                $shortLeave->update(['approved_by' => auth()->user()->id]);
                return redirect('admin/globalLeave');    
            }
            // Update the field 
            if($request->reason){
            $shortLeave->update(['reason' => $request->reason]);
            }

            $shortLeave->update(['approved_by' => null]);
            $shortLeave->update(['approved' => 0]); 

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
