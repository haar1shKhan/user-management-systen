<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortLeave;
use App\Models\User;

class ShortLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $shortLeave = ShortLeave::with('user','approvedBy')->get();
        $page_title = 'Short Leave Application';
        $trash = false;
        $data['page_title']=$page_title;
        $data['shortLeave']=$shortLeave;
        $data['trash']=$trash;
        $data['url']='shortLeave';
 
        return view('admin.shortLeave.index',$data);
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
        $shortLeave = ShortLeave::create([
            'date' => '1/1/21', // You may want to adjust this as needed
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'reason' => $request->input('reason'),
        ]);
        $user->shortLeave()->save($shortLeave);

        return redirect('admin/shortLeave');

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

        return redirect('admin/shortLeave');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        ShortLeave::find($id)->delete();
        return redirect('admin/shortLeave');
    }
}
