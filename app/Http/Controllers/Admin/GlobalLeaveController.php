<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\LeaveRequestMail;
use Illuminate\Http\Request;
use App\Models\LeaveEntitlement;
use App\Models\ShortLeave;
use App\Models\LateAttendance;
use App\Models\longLeave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;


class GlobalLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $base_url = 'admin/leave-requests';

    public function index()
    {
        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $longLeaves = LongLeave::orderBy('id', 'desc')->get();
        $shortLeave = ShortLeave::orderBy('id', 'desc')->get();
        $lateAttendances = LateAttendance::orderBy('id', 'desc')->get();

        $page_title = 'طلبات الإجازة';
        $trash = false;
        $data['url']='leave.requests';

        $data['longLeaves']=$longLeaves;
        $data['shortLeave']=$shortLeave;
        $data['lateAttendances']=$lateAttendances;
        $data['page_title']=$page_title;
        
        return view('admin.globalLeave.index',$data);
    }

    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                
                        
                        $totalDays = $userEntitlement->leave_taken + $numberOfDays;
                        $userEntitlement->update(['leave_taken'=>$totalDays]);
                        $longLeave->update(['approved' => 1]);
                        $longLeave->update(['approved' => 1]);

                        $data =[
                            "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
                            'leave_type' => $userEntitlement->policy->title,
                            'start_date' => $longLeave->from,
                            'end_date' => $longLeave->to,
                            'reason' => $longLeave->reason,
                            'status' => 'Approved'
                        ];
        
                        Mail::to($longLeave->user->email)->send(new LeaveRequestMail($data));
        
                
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
                    
                    $data =[
                        "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
                        'leave_type' =>'Late Attendance',
                        'start_date' => $lateAttendance->from,
                        'end_date' => $lateAttendance->to,
                        'reason' => $lateAttendance->reason,
                        'status' => 'Approved'
                    ];
    
                    Mail::to($lateAttendance->user->email)->send(new LeaveRequestMail($data));
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
                    
                    $data =[
                        "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
                        'leave_type' =>'Short Leave',
                        'start_date' => $shortLeave->from,
                        'end_date' => $shortLeave->to,
                        'reason' => $shortLeave->reason,
                        'status' => 'Approved'
                    ];
    
                    Mail::to($shortLeave->user->email)->send(new LeaveRequestMail($data));

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

                    $data =[
                        "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
                        'leave_type' => $userEntitlement->policy->title,
                        'start_date' => $longLeave->from,
                        'end_date' => $longLeave->to,
                        'reason' => $longLeave->reason,
                        'status' => 'Rejected'
                    ];
    
                    Mail::to($longLeave->user->email)->send(new LeaveRequestMail($data));  
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
                    
                    $data =[
                        "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
                        'leave_type' =>'Late Attendance',
                        'start_date' => $lateAttendance->from,
                        'end_date' => $lateAttendance->to,
                        'reason' => $lateAttendance->reason,
                        'status' => 'Rejected'
                    ];
    
                    Mail::to($lateAttendance->user->email)->send(new LeaveRequestMail($data));
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

                    $data =[
                        "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
                        'leave_type' =>'Short Leave',
                        'start_date' => $shortLeave->from,
                        'end_date' => $shortLeave->to,
                        'reason' => $shortLeave->reason,
                        'status' => 'Approved'
                    ];
    
                    Mail::to($shortLeave->user->email)->send(new LeaveRequestMail($data));
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
