<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ChangePasswordController extends Controller
{
    //
    public function index(Request $request){

        return view('admin.changePassword.index'); 
    }

    public function update(Request $request){
        $validation = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        
        if (Hash::check($request->current_password, $user->password)){
           $user->update(['password'=> bcrypt($request->new_password)]);
           return redirect()->route('admin.account.profile');
        }

        $status = [
            'current_password' => "Current password is incorrect."
        ];
        
        return redirect()->route('admin.change-password')->withErrors($status);
        
    }
}
