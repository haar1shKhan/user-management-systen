<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class changePasswordController extends Controller
{
    //
    public function index(Request $request){

        return view('admin.changePassword.index');
    }

    public function update(Request $request, string $id){
        // dd($request->all());
        $validation = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user=User::findOrFail($id);

        if (Hash::check($request->current_password, $user->password)){
           $user->update(['password'=> bcrypt($request->new_password)]);
           return redirect("/admin/change-password");
        }
        // dd("false");
        $statusMessage = "Current password is incorrect.";
        return redirect("/admin/change-password")->withErrors(['current_password' => $statusMessage]);
        
    }
}
