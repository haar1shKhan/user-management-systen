<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LateAttendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;


class LateAttendanceController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public $base_url = "admin/lateAttendance";

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
        ->whereDate("created_at",$currentDate)
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
}
