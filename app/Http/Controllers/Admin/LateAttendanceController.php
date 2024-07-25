<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LateAttendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\LeaveRequestMail;
use App\Mail\LeaveStatusMail;
use DateTime;
use Illuminate\Support\Facades\Mail;

class LateAttendanceController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public $base_url = "admin/late-attendance";

    public function index()
    {
        abort_if(Gate::denies('late_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lateAttendances = LateAttendance::where('user_id',auth()->user()->id)->with('user','approvedBy')->orderBy('id', 'desc')->get();
        $page_title = 'Late Attendance';
        $trash = false;
        $data['page_title']=$page_title;
        $data['trash']=$trash;
        $data['lateAttendances']=$lateAttendances;
        $data['url']='lateAttendance';
 
        return view('admin.lateAttendance.index',$data);
    }

    public function store(Request $request)
    {   
        abort_if(Gate::denies('late_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $validation = $request->validate([
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            'reason' => 'required',
        ]);

        $startTime = Carbon::parse($request->input('from'));
        $endTime = Carbon::parse( $request->input('to'));
        $user = User::find(auth()->user()->id);
        $currentDate =  Carbon::now()->toDateString();

        if ($startTime->gt($endTime)) {
            $statusMessage = 'Start Time cannot be after End Time, please Insert Correct input.';
            return redirect($this->base_url)->with('status', $statusMessage);
        }
    
        if ($startTime->eq($endTime)) {
            $statusMessage = 'Cannot have Late leave on same time';
            return redirect($this->base_url)->with('status', $statusMessage);
        }
    

        $existingLeave = lateAttendance::where('user_id', auth()->user()->id)
        ->whereDate("date", $request->input('date'))
        ->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('from', [$startTime, $endTime])
                  ->orWhereBetween('to', [$startTime, $endTime])
                  ->orWhere(function ($query) use ($startTime, $endTime) {
                      $query->where('from', '<', $startTime)
                            ->where('to', '>', $endTime);
                  });
        })
        ->get(); // Use get() to retrieve multiple overlapping records

    if ($existingLeave->count() > 0) {
        $overlappingDates = $existingLeave->pluck('from', 'to')->toArray();

        $statusMessage = 'You have overlapping leave time on ';
        foreach ($overlappingDates as $toTime => $fromTime) {
            $fromTimeFormatted = Carbon::parse($fromTime)->format('g:i A'); // 12-hour format
            $toTimeFormatted = Carbon::parse($toTime)->format('g:i A');     // 12-hour format
    
            $statusMessage .= "{$fromTimeFormatted} to {$toTimeFormatted}, ";
        }
        $statusMessage = rtrim($statusMessage, ', '); // Remove trailing comma and space

        return redirect($this->base_url)->with('status', $statusMessage);
    }

        $lateAttendance = lateAttendance::create([
            'date' => $request->input('date'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'reason' => $request->input('reason'),
        ]);

        $user->lateAttendance()->save($lateAttendance);

        $from = new DateTime($request->input('from'));
        $to = new DateTime($request->input('to'));
        $duration = $from->diff($to);

        $data =[
            "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
            "date" => date("d/m/Y", strtotime($request->input('date'))),
            'leave_type' => "Late Attendance",
            'start_date' => $from->format('h:i a'),
            'end_date' => $to->format('h:i a'),
            'days' => $duration->format('%h hours %i miniutes '),
            'reason' => $request->input("reason"),
        ];

        Mail::to(config('settings.store_email'))->send(new LeaveRequestMail($data));

        return redirect($this->base_url);

    }

    public function update(Request $request, string $id)
    {
        //
        abort_if(Gate::denies('late_attendance_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $validation = $request->validate([
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            'reason' => 'required',
        ]);

        $startTime = Carbon::parse($request->input('from'));
        $endTime = Carbon::parse( $request->input('to'));
        $user = User::find(auth()->user()->id);
        $currentDate =  Carbon::now()->toDateString();

        if ($startTime->gt($endTime)) {
            $statusMessage = 'Start Time cannot be after End Time, please Insert Correct input.';
            return redirect($this->base_url)->with('status', $statusMessage);
        }
    
        if ($startTime->eq($endTime)) {
            $statusMessage = 'Cannot have Late leave on same time';
            return redirect($this->base_url)->with('status', $statusMessage);
        }

        $lateAttendance = LateAttendance::findOrFail($id);


        // Update the field 
     
        $lateAttendance->update([
            'date' => $request->input('date'),
            'from' => $request->from,
            'to' => $request->to,
            'reason' => $request->reason
        ]);
        

        return redirect($this->base_url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        abort_if(Gate::denies('late_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        LateAttendance::find($id)->delete();
        return redirect($this->base_url);
    }

    public function massAction(Request $request)
    {
        abort_if(Gate::denies('late_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $massAction = $request['massAction'];

        foreach ($massAction as $id) {
            
            LateAttendance::find($id)->delete();

        }
        return redirect($this->base_url);

    }

    /**
    * Updtate Status to Approved.
    */
    public function approve(LateAttendance $leave){

        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $from = new DateTime($leave->from);
        $to = new DateTime($leave->to);
        $duration = $from->diff($to);
        
        $leave->update([
            'approved' => 1,
            'approved_by' => auth()->user()->id,
        ]);

        $this->sendEmail($leave, 'Short Leave', $duration, 'Approved');

        return redirect()->route('admin.leave.requests');
    }

    /**
    * Updtate Status to Rejected.
    */
    public function reject(Request $request, LateAttendance $leave){

        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $from = new DateTime($leave->from);
        $to = new DateTime($leave->to);
        $duration = $from->diff($to);
        
        $leave->update([
            'approved' => -1,
            'reject_reason' => $request->input('reject_reason'),
            'approved_by' => auth()->user()->id,
        ]);

        $this->sendEmail($leave, 'Short Leave', $duration, 'Rejected');

        return redirect()->route('admin.leave.requests');
    }

    /**
    * Updtate Status to Pending.
    */    
    public function pending(LateAttendance $leave){

        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $from = new DateTime($leave->from);
        $to = new DateTime($leave->to);
        $duration = $from->diff($to);
        
        $leave->update([
            'approved' => 0,
            'approved_by' => null,
        ]);

        $this->sendEmail($leave, 'Short Leave', $duration, 'set to Pending');

        return redirect()->route('admin.leave.requests');
    }

    public function sendEmail($leave, $entitlement, $duration, $status){

        $data = [
            'username' => $leave->user->first_name.' '.$leave->user->last_name,
            'status'  => $status,
            'leave_type' => $entitlement,
            'approved_by' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'date' => date('d/m/Y', strtotime($leave->date)),
            'duration' => $duration->format('%h hours %i miniutes '),
            'from' => date('h:i a', strtotime($leave->from)),
            'to' => date('h:i a', strtotime($leave->to)),
        ];
    
        Mail::to($leave->user->email)->send(new LeaveStatusMail($data));
    }

    public function print(LateAttendance $leave){
        $leave->load(['user.roles', 'user.jobDetail','user.profile']);
        $startHour = Carbon::parse($leave->from);
        $endHour = Carbon::parse($leave->to);
        $totalLeaveHours = $startHour->diffInHours($endHour) + 1;
        $data =[
            "leave" => $leave,
            "totalLeaveHours" => $totalLeaveHours
        ];
        return view('printable.report',$data);
    }
}
