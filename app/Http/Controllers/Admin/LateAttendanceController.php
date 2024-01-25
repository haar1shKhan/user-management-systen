<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LateAttendance;

class LateAttendanceController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $lateAttendances = LateAttendance::with('user','approvedBy')->get();
        $page_title = 'Late Attendance Application';
        $trash = false;
        $data['page_title']=$page_title;
        $data['trash']=$trash;
        $data['lateAttendances']=$lateAttendances;
        $data['url']='lateAttendance';
 
        return view('admin.lateAttendance.index',$data);
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
        $user = User::find(auth()->user()->id);
        // dd($user);
        // die;
        $lateAttendance = lateAttendance::create([
            'date' => '1/1/21', // You may want to adjust this as needed
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'reason' => $request->input('reason'),
        ]);
        $user->lateAttendance()->save($lateAttendance);

        return redirect('admin/lateAttendance');

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
        //
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

        return redirect('admin/lateAttendance');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        LateAttendance::find($id)->delete();
        return redirect('admin/lateAttendance');
    }
}
