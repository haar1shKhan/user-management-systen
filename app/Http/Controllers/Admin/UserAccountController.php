<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Profile;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = User::with('roles','profile','jobDetail')->find(auth()->user()->id);

        $data['user'] = $user;
        $data['page_title'] = "User Account";
        return view('admin.userAccount.index', $data);

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
        $user = User::with('roles','profile','jobDetail')->find(auth()->user()->id);
        $roles = Role::all();

        $data['user'] = $user;
        $data['roles'] = $roles;
        $data['page_title'] = "User Account";

        return view('admin.userAccount.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);



        if($user->profile==NULL){

            if ($request->hasFile('image')) {

                $fileName = $user->id . '.' . $request->image->extension();
                $request->file('image')->storeAs('public/profile_images', $fileName);
        
                // Update profile data with the new image
                $user->profile->update([
                    'image' => $fileName,
                    'user_id' => $user->id,
                ]);
            }
    
                Profile::create([
    
                'email' => $request->input('personal_email'),
                'phone' => $request->input('phone'),
                'mobile' => $request->input('mobile'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'nationality' => $request->input('nationality'),
                'marital_status' => $request->input('marital_status'),
                'biography' => $request->input('biography'),
                'religion' => $request->input('religion'),
                'address' => $request->input('address'),
                'address2' => $request->input('address2'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
                'country' => $request->input('country'),
                'user_id' => $user->id,
    
            ]);

            return redirect('/admin/user-account');

        }
        
        if ($request->hasFile('image')) {
            $fileName = $user->id . '.' . $request->image->extension();
            $request->file('image')->storeAs('public/profile_images', $fileName);
    
            // Update profile data with the new image
            $user->profile->update([
                'image' => $fileName,
            ]);
        }

        $user->profile->update([

            'email' => $request->input('personal_email'),
            'phone' => $request->input('phone'),
            'mobile' => $request->input('mobile'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'nationality' => $request->input('nationality'),
            'marital_status' => $request->input('marital_status'),
            'biography' => $request->input('biography'),
            'religion' => $request->input('religion'),
            'address' => $request->input('address'),
            'address2' => $request->input('address2'),
            'city' => $request->input('city'),
            'province' => $request->input('province'),
            'country' => $request->input('country'),

        ]);

        return redirect('/admin/user-account');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
