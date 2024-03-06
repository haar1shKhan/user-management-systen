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
    public $base_url = 'admin/globalLeave';

    public function index()
    {
        //
        $longLeaves = LongLeave::orderBy('id', 'desc')->get();
        $shortLeave = ShortLeave::orderBy('id', 'desc')->get();
        $lateAttendances = LateAttendance::orderBy('id', 'desc')->get();

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

        if($request->type == "longLeave"){


            $longLeave= longLeave::findOrFail($id);
            $userEntitlement = LeaveEntitlement::findOrFail($longLeave->entitlement_id);
            // dd($userEntitlement);

            if($longLeave->approved==1 && $request->has('approve')){
                return redirect($this->base_url);
            }

            if($longLeave->approved==0 && $request->has('pending')){
                return redirect($this->base_url);
            }

            if($longLeave->approved==-1 && $request->has('reject')){
                return redirect($this->base_url);
            }

            $startDate = Carbon::parse($longLeave->from);
            $endDate = Carbon::parse($longLeave->to);
            $numberOfDays = $startDate->diffInDays($endDate);
            // Check if the button clicked is for approval or rejection
            if ($request->has('approve')) {
               
                $totalDays = $userEntitlement->leave_taken + $numberOfDays;
                $userEntitlement->update(['leave_taken'=>$totalDays]);
                $longLeave->update(['approved' => 1]);
 
     
            } elseif ($request->has('reject')) {

                if($longLeave->approved==1){
                    $totalDays = $userEntitlement->leave_taken - $numberOfDays;
                    $userEntitlement->update(['leave_taken'=>$totalDays]);
                }
                
                $longLeave->update(['approved' => -1]); //-1 represents rejection,
            }
            
            // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
            if(auth()->user()->roles[0]->title == "Admin" && !$request->has('pending') )
            {
                $longLeave->update(['approved_by' => auth()->user()->id]);
                return redirect($this->base_url);
            }
            
            if($longLeave->approved==1){
                $totalDays = $userEntitlement->leave_taken - $numberOfDays;
                $userEntitlement->update(['leave_taken'=>$totalDays]);
            }
            $longLeave->update(['approved_by' => null]);
            $longLeave->update(['approved' => 0]); 
            

            return redirect($this->base_url);
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
                return redirect($this->base_url);
            }
            // Update the field 
            if($request->reason){
            $lateAttendance->update(['reason' => $request->reason]);
            }

            $lateAttendance->update(['approved_by' => null]);
            $lateAttendance->update(['approved' => 0]); 

            return redirect($this->base_url);
        }


        if($request->type=="shortLeave"){

            $shortLeave = ShortLeave::findOrFail($id);

            // Check if the button clicked is for approval or rejection
            if ($request->has('approve')) {
                $shortLeave->update(['approved' => 1]);
            } elseif ($request->has('reject')) {
                $shortLeave->update(['approved' => -1]); 
            }
        
            // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
            if(auth()->user()->roles[0]->title == "Admin"  && !$request->has('pending'))
            {
                $shortLeave->update(['approved_by' => auth()->user()->id]);
                return redirect($this->base_url);    
            }
            // Update the field 
            if($request->reason){
            $shortLeave->update(['reason' => $request->reason]);
            }

            $shortLeave->update(['approved_by' => null]);
            $shortLeave->update(['approved' => 0]); 

            return redirect($this->base_url);    

        }

    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function massAction(Request $request)
    {

        $massAction = $request['massAction'];
        
        if($request->action_type == "accept_all"){

            foreach ($massAction as $id) {
            
                if($request->tableId == "basic-1"){


                $longLeave= longLeave::findOrFail($id);

                if($longLeave->approved==1 && $request->action_type == "accept_all"){
                    continue;
                }

                $userEntitlement = LeaveEntitlement::find($longLeave->entitlement_id);
                $startDate = Carbon::parse($longLeave->from);
                $endDate = Carbon::parse($longLeave->to);
                $numberOfDays = $startDate->diffInDays($endDate);
                
                // Check if the button clicked is for approval or rejection
                
                    if($userEntitlement->leave_taken==0){
                        
                        $userEntitlement->update(['leave_taken'=> $numberOfDays]);
                        $longLeave->update(['approved' => 1]);

                    } 
                    else{
                        
                        $totalDays = $userEntitlement->leave_taken + $numberOfDays;
                        $userEntitlement->update(['leave_taken'=>$totalDays]);
                        $longLeave->update(['approved' => 1]);

                }   
        
                
                // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
                if(auth()->user()->roles[0]->title == "Admin")
                {
                    $longLeave->update(['approved_by' => auth()->user()->id]);
                }
                }

                if($request->tableId == "basic-2"){

                    $lateAttendance = LateAttendance::findOrFail($id);

                    // Check if the button clicked is for approval or rejection
                        $lateAttendance->update(['approved' => 1]);
                
                    // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
                    if(auth()->user()->roles[0]->title == "Admin")
                    {
                        $lateAttendance->update(['approved_by' => auth()->user()->id]);
                    }
                    // Update the field 
                    if($request->reason){
                    $lateAttendance->update(['reason' => $request->reason]);
                    }

                }

                if($request->tableId == "basic-3"){

                    $shortLeave = ShortLeave::findOrFail($id);

                    // Check if the button clicked is for approval or rejection
                        $shortLeave->update(['approved' => 1]);
                
                    // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
                    if(auth()->user()->roles[0]->title == "Admin")
                    {
                        $shortLeave->update(['approved_by' => auth()->user()->id]);
                    }
                    // Update the field 
                    if($request->reason){
                     $shortLeave->update(['reason' => $request->reason]);
                    }

                }
            }
        }

        if($request->action_type == "reject_all"){

            foreach($massAction as $id){
                if($request->tableId == "basic-1") {
                    $longLeave= longLeave::findOrFail($id);

                    if($longLeave->approved==0 && $request->action_type == "reject"){
                        continue;
                    }

                    $userEntitlement = LeaveEntitlement::find($longLeave->entitlement_id);
                    $startDate = Carbon::parse($longLeave->from);
                    $endDate = Carbon::parse($longLeave->to);
                    $numberOfDays = $startDate->diffInDays($endDate);


                    if(auth()->user()->roles[0]->title == "Admin")
                    {
                        $longLeave->update(['approved_by' => auth()->user()->id]);
                    }

                    if($longLeave->approved==1){
                        $totalDays = $userEntitlement->leave_taken - $numberOfDays;
                        $userEntitlement->update(['leave_taken'=>$totalDays]);
                    }
                    $longLeave->update(['approved' => -1]); //-1 represents rejection,
                }   

                if($request->tableId == "basic-2"){

                    $lateAttendance = LateAttendance::findOrFail($id);

                    // Check if the button clicked is for approval or rejection
                     $lateAttendance->update(['approved' => -1]);
                
                    // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
                    if(auth()->user()->roles[0]->title == "Admin")
                    {
                        $lateAttendance->update(['approved_by' => auth()->user()->id]);
                    }
                    // Update the field 
                    if($request->reason){
                    $lateAttendance->update(['reason' => $request->reason]);
                    }

                }

                if($request->tableId == "basic-3"){

                    $shortLeave = ShortLeave::findOrFail($id);

                    // Check if the button clicked is for approval or rejection
                     $shortLeave->update(['approved' => -1]);
                
                    // Update the approved_by field with the supervisor's ID (assuming you have the supervisor ID in your request)
                    if(auth()->user()->roles[0]->title == "Admin")
                    {
                        $shortLeave->update(['approved_by' => auth()->user()->id]);
                    }
                    // Update the field 
                    if($request->reason){
                    $shortLeave->update(['reason' => $request->reason]);
                    }

                }
            }

        }

        if($request->action_type == "pending_all"){

            foreach($massAction as $id){

              if($request->tableId == "basic-1")  {
                    $longLeave= longLeave::findOrFail($id);

                    if($longLeave->approved==-1 && $request->has('pending')){
                        continue;
                    }

                    $userEntitlement = LeaveEntitlement::find($longLeave->entitlement_id);
                    $startDate = Carbon::parse($longLeave->from);
                    $endDate = Carbon::parse($longLeave->to);
                    $numberOfDays = $startDate->diffInDays($endDate);

                    if($longLeave->approved==1){
                        $totalDays = $userEntitlement->leave_taken - $numberOfDays;
                        $userEntitlement->update(['leave_taken'=>$totalDays]);
                    }
                    $longLeave->update(['approved_by' => null]);
                    $longLeave->update(['approved' => 0]); 
                }

              if($request->tableId == "basic-2")  {

                    $lateAttendance = LateAttendance::findOrFail($id);
                    $lateAttendance->update(['approved_by' => null]);
                    $lateAttendance->update(['approved' => 0]); 
                    
                }

              if($request->tableId == "basic-3")  {

                    $shortLeave = ShortLeave::findOrFail($id);
                    $shortLeave->update(['approved_by' => null]);
                    $shortLeave->update(['approved' => 0]); 
                    
                }
            }

        }
        return redirect($this->base_url);
    }
}
