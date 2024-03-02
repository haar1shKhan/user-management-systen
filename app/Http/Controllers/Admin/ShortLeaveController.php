<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortLeave;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;


class ShortLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public $base_url = "admin/short-leave";

    public function index()
    {
        abort_if(Gate::denies('short_leave_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shortLeave = ShortLeave::where('user_id',auth()->user()->id)->with('user','approvedBy')->orderBy('id', 'desc')->get();
        $page_title = 'Short Leave';
        $trash = false;
        $data['page_title']=$page_title;
        $data['shortLeave']=$shortLeave;
        $data['trash']=$trash;
        $data['url']='short-leave';
 
        return view('admin.short-leave.index',$data);
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
        abort_if(Gate::denies('short_leave_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validation = $request->validate([
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            'reason' => 'required',
        ]);

        $user = User::find(auth()->user()->id);

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
     
        $existingLeave = ShortLeave::where('user_id', auth()->user()->id)
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
         
        $shortLeave = ShortLeave::create([
            'date' => $request->input('date'), // You may want to adjust this as needed
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'reason' => $request->input('reason'),
        ]);
        $user->shortLeave()->save($shortLeave);

        return redirect($this->base_url);

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
        abort_if(Gate::denies('short_leave_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

        $shortLeave = ShortLeave::findOrFail($id);

        // Update the field 
 
        $shortLeave->update(
            [
                'date' => $request->date,
                'from' => $request->from,
                'to' => $request->to,
                'reason' => $request->reason
            ]
        );
      

        return redirect($this->base_url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('short_leave_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $shortleave = ShortLeave::findOrFail($id);
        if ($shortleave->approved){
            return redirect($this->base_url)->with('status', "Sorry you can't Delete Approved Requests");
        }
        ShortLeave::find($id)->delete();
        return redirect($this->base_url);
    }

    public function massDelete(Request $request)
    {
        abort_if(Gate::denies('short_leave_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $massDelete = $request['massDelete'];

        foreach ($massDelete as $id) {

            $shortleave = ShortLeave::findOrFail($id);
            if (!$shortleave->approved){
                ShortLeave::find($id)->delete();
            }

        }
        return redirect($this->base_url);

    }
}
