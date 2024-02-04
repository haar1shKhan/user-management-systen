<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LongLeave;
use App\Models\ShortLeave;
use App\Models\LateAttendance;

class GlobalLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $longLeaves = LongLeave::all();
        $shortLeaves = ShortLeave::all();
        $lateAttendances = LateAttendance::all();

        $page_title = 'Global leave';
        $trash = false;
        $data['url']='globalLeave';

        $data['trash']=$trash;
        $data['longLeaves']=$longLeaves;
        $data['shortLeaves']=$shortLeaves;
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
