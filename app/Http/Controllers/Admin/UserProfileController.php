<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Profile;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::with('roles','profile')->find($user_id);

        $data = [
            'user' => $user,
            'page_title' => 'My Profile',
        ];

        return view('admin.user-profile.index', $data);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user_id = auth()->user()->id;
        $user = User::with('roles','profile')->find($user_id);
        $roles = Role::all();

        $data = [
            'user' => $user,
            'roles' => $roles, 
            'page_title' => "Edit profile",
        ];

        return view('admin.user-profile.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validation = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'religion' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
        ]);

        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);

        if($user->profile == NULL){
            
            $profile = Profile::create([
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

            if ($request->hasFile('image')) {
                $fileName = $user->id . '.' . $request->image->extension();
                $request->file('image')->storeAs('public/profile_images', $fileName);

                $profile->update([
                    'image' => $fileName,
                ]);
            }

            return redirect()->route('admin.account.profile');

        }
        
        if ($request->hasFile('image')) {
            $fileName = $user->id . '.' . $request->image->extension();
            $request->file('image')->storeAs('public/profile_images', $fileName);

            $user->profile->update([
                'image' => $fileName,
            ]);
        }

        if(empty($user->profile->date_of_birth)){
            $user->profile->update([
                'date_of_birth' => $request->input('date_of_birth'),
            ]);
        }

        if(empty($user->profile->nationality)){
            $user->profile->update([
                'nationality' => $request->input('nationality'),
            ]);
        }
        
        $user->profile->update([
            'email' => $request->input('personal_email'),
            'phone' => $request->input('phone'),
            'mobile' => $request->input('mobile'),
            'gender' => $request->input('gender'),
            'marital_status' => $request->input('marital_status'),
            'biography' => $request->input('biography'),
            'religion' => $request->input('religion'),
            'address' => $request->input('address'),
            'address2' => $request->input('address2'),
            'city' => $request->input('city'),
            'province' => $request->input('province'),
            'country' => $request->input('country'),
        ]);

        return redirect()->route('admin.account.profile');
    }
}
