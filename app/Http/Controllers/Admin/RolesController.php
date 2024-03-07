<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;



class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::with('permissions')->get();
        $data['trash'] = false;

        if ($request->get('trash')){
            $roles = Role::with('permissions')->onlyTrashed()->get();
            $data['trash'] = true;
        }
        // echo '<pre>';
        // echo $roles;
        // die;
        $data['page_title'] = 'Dashboard';
        $data['roles'] = $roles;
        $data['url'] = 'role';
        
       
        return view('admin.roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all();
        
        // $categories = [];
        
        // foreach ($permissions as $item) {

        //     //$parts = explode('_', $item['slug']);
        //     $permission_title = $item->title;

        //     $str = preg_replace('/\W\w+\s*(\W*)$/','$1',$permission_title);
            
        //     // $words =  array_splice($parts, 0, -1);
        //     // $category = "";

        //     // foreach ($words as $value) {
        //     //     $category .= $value." ";
        //     // }
           
        //     if (!in_array($str, $categories)) {
        //         $categories[] = $str;
        //     }
        // }

        $categories=[];

        foreach ($permissions as $item) {
            $parts = explode('_', $item['slug']);
        
            // Assuming the base name is the first part of the title
            $baseName = $parts[0];
        
            // Add to the permissions array
            if (!in_array($baseName, $categories)) {
                $categories[] = $baseName;
            }
        }
        
        $data['permissions'] = $permissions;
        $data['categories'] = $categories;
        $data['url'] = 'role';

       return view('admin/roles/create',$data);
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

        $role = new Role([
            'title'=> $request['title'],
        ]);
        $role->save();

        if ($request->has('permissions')) {
            $role->permissions()->sync($request['permissions']);
        } else {
            // If no permissions are selected, remove all existing permissions
            $role->permissions()->detach();
        }

        return redirect('admin/roles');
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
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role = Role::with('permissions')->find($id);
        $roles = Role::all();
        $permissions = Permission::all();
        if(is_null($role))
        {
            return redirect('roles/index');
        }

        $categories=[];

        foreach ($permissions as $item) {
            $parts = explode('_', $item['slug']);
        
            // Assuming the base name is the first part of the title
            $baseName = $parts[0];
        
            // Add to the permissions array
            if (!in_array($baseName, $categories)) {
                $categories[] = $baseName;
            }
        }

        $data['role'] = $role;
        $data['permissions'] = $permissions;
        
        $data['categories'] = $categories;
        $data['url'] = 'role';
      
        return view('admin/roles/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role->title = $request['title'];
        $role->save();

        if ($request->has('permissions')) {
            $role->permissions()->sync($request['permissions']);
        } else {
            // If no permissions are selected, remove all existing permissions
            $role->permissions()->detach();
        }

        return redirect('admin/roles');
    }

    
    public function restore(string $id)
    {
        Role::withTrashed()->find($id)->restore();
        return redirect('admin/roles?trash=1');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(!$role->id === 1)
        {
            $role->delete();
        }

        return redirect('admin/roles');
    }

    public function massAction(Request $request)
    {
        $massAction = $request['massAction'];
        $actionType = $request['action_type'];
        
        if($actionType == 'restoreAll'){

            foreach ($massAction as $id) {

            Role::withTrashed()->find($id)->restore();
            
        }
        return redirect('admin/roles?trash=1');
        }

        if($actionType == 'forceDestroyAll'){

            abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            
            foreach ($massAction as $id) {
                
                Role::withTrashed()->find($id)->forceDelete();
                
            }
            return redirect('admin/roles?trash=1');
            
        }
        
        if($actionType == 'destroyAll'){

            abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            
            foreach ($massAction as $id) {

                $role = Role::find($id);
        
                if(!$role->id === 1){
                    Role::find($id)->delete();
                }
            }
            return redirect('admin/roles');
        }
        
        return redirect('admin/roles');
    }
    
    public function forceDelete(string $id)
    {
        //
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Role::withTrashed()->find($id)->forceDelete();
        return redirect('admin/roles?trash=1');

    }
}
