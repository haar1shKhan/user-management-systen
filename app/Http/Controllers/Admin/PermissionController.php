<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Gate;
use Symfony\Component\HttpFoundation\Response;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::get();
     
        $data['page_title'] = 'Dashboard';
        $data['permissions'] = $permissions;
        $data['trash'] = null;
        $data['url'] = 'permission';
        
       
        return view('admin.permissions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['url'] = 'permission';
        return view('admin/permissions/create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
            'slug' => 'required'
        ]);

        $Permission = new Permission([
            'title'=> $request['title'],
            'slug'=> $request['slug'],
        ]);
        $Permission->save();

        return redirect('admin/permissions');
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

        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission = Permission::find($id);
        if(is_null($permission))
        {
            return redirect('permission/index');
        }
        $data['permission'] = $permission;
        $data['url'] = 'permission';
      
        return view('admin/permissions/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $permission=Permission::find($id);
        $permission->title = $request['title'];
        $permission->slug = $request['slug'];
        $permission->save();

        return redirect('admin/permissions');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

          Permission::find($id)->delete();
          return redirect('admin/permissions');
    }

    public function massAction(Request $request)
    {
        $massAction = $request['massAction'];
        dd($massAction);
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        foreach ($massAction as $id) {
            
            Permission::find($id)->delete();
        }
        return redirect('admin/permissions');

    }
}
