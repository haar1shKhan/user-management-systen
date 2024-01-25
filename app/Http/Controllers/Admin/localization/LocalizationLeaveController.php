<?php

namespace App\Http\Controllers\admin\localization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LocalizationLeave;


class LocalizationLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $longLeaveType = LocalizationLeave::get();
        $data['page_title'] = 'System';
        $data['longLeaveType'] = $longLeaveType;
        $data['trash'] = null;
        $data['url'] = 'localization';

        return view('admin.localization.longLeave.index',$data);
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
        $request->validate([
            'title' => 'required',
        ]);

        $LocalizationLeave = new LocalizationLeave([
            'title'=> $request['title'],
        ]);
        $LocalizationLeave->save();

        return redirect('admin/localization/longLeave');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required',
        ]);

        $LocalizationLeave=LocalizationLeave::find($id);
        $LocalizationLeave->title = $request['title'];
        $LocalizationLeave->save();

        return redirect('admin/localization/longLeave');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        LocalizationLeave::find($id)->delete();
        return redirect('admin/localization/longLeave');
    }

    public function massAction(Request $request)
    {
        $massAction = $request['massAction'];
        
        // abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // echo '<pre>';
        foreach ($massAction as $id) {
            // echo $id . '<br>';
            LocalizationLeave::find($id)->delete();
        }
        return redirect('admin/localization/longLeave');

    }
}
