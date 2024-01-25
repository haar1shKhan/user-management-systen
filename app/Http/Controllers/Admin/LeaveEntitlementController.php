<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveEntitlement;


class LeaveEntitlementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $leaveEntitlement = LeaveEntitlement::get();
        $data['page_title'] = 'Leave Setting';
        $data['leaveEntitlement'] = $leaveEntitlement;
        $data['trash'] = null;
        $data['url'] = 'leaveSettings';

        return view('admin.leaveSettings.leaveEntitlement.index',$data);
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
