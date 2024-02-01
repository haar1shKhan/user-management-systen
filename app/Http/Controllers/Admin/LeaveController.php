<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeavePolicies;


class LeaveController extends Controller
{  /**
    * Display a listing of the resource.
    */
   public function index()
   {
       //
       $longLeaveList = LeavePolicies::get();
       $page_title = 'Leave Application';
       $trash = false;
       $data['page_title']=$page_title;
       $data['longLeaveList']=$longLeaveList;
       $data['trash']=$trash;
       $data['url']='longLeave';

       return view('admin.LongLeave.index',$data);
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
       //
       $page_title = 'long Leave Application';
       $data['page_title']=$page_title;
       return view('admin.passportApplication.index',$data);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {    dd($request->all());
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
