<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_user;
use App\Models\Profile;
use App\Models\JobDetail;
use App\Models\LeavePolicies;
use App\Models\LeaveEntitlement;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')->get();
        $data['trash'] = false;
        
        if ($request->get('trash')){
            $users = User::with('roles')->onlyTrashed()->get();
            $data['trash'] = true;
        }
        
        $data['page_title'] = 'Dashboard';
        $data['users'] = $users;
        return view('admin.users.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::all();
        $supervisors = User::all();



        $data['roles']=$roles;
        $data["supervisors"] = $supervisors;

      
        return view('admin/users/create',$data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $validation = $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     "supervisor_id" => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|confirmed',
        //     'password_confirmation' => 'required',
        //     'role' => 'required',
        //     'date_of_birth' => 'required',
        //     'phone' => 'required',
        //     'gender' => 'required',
        //     'marital_status' => 'required',
        //     'nationality' => 'required',
        //     'religion' => 'required',
        //     'passport' => 'required',
        //     'passport_issued_at' => 'required',
        //     'passport_expires_at' => 'required',
        //     'nid' => 'required',
        //     'nid_issued_at' => 'required',
        //     'nid_expires_at' => 'required',
        //     'visa' => 'required',
        //     'visa_issued_at' => 'required',
        //     'visa_expires_at' => 'required',
        //     'hired_at' => 'required',
        //     'address' => 'required',
        //     'city' => 'required',
        //     'source_of_hire' => 'required',
        //     'job_type' => 'required',
        //     'status' => 'required',
        //     'education' => 'required',
        //     'work_experience' => 'required',
        //     'salary' => 'required',
        //     'province' => 'required',
        //     'country' => 'required',
        //     'bank_name' => 'required',
        //     'bank_account_number' => 'required',
        //     'iban' => 'required',
        //     'payment_method' => 'required',
        //     'image' => 'image|mimes:jpeg,png,jpg',
        // ]);

        $user = new User([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'), //
            'password' => bcrypt($request->input('password')),//
        ]);
        
        $user->save();

        $user->roles()->sync([$request->input('role')]);

        // if($request->image){
        //     $fileName = $user->id . '.' . $request->image->extension();
        //     $request->file('image')->storeAs('public/profile_images', $fileName);
        // }

        // if($request->passport_file){
        //     $PassportFile = $user->id . '.' . $request->passport_file->extension();
        //     $request->file('passport_file')->storeAs('public/passport_files', $PassportFile);
        // }

        // if($request->nid_file){
        // $nidFile = $user->id . '.' . $request->nid_file->extension();
        // // $fileName = time() . '.' . $request->image->extension();
        // $request->file('nid_file')->storeAs('public/nid_files', $nidFile);
        // }

        // if($request->visa_file){
        // $visaFile = $user->id . '.' . $request->visa_file->extension();
        // // $fileName = time() . '.' . $request->image->extension();
        // $request->file('visa_file')->storeAs('public/visa_files', $visaFile);
        // }

        // $profile = new Profile([
        //     'image' => $fileName ?? null,
        //     'image' => $fileName ?? null,
        //     'email' => $request->input('personal_email'),
        //     'phone' => $request->input('phone'),
        //     'mobile' => $request->input('mobile'),
        //     'date_of_birth' => $request->input('date_of_birth'),
        //     'gender' => $request->input('gender'),
        //     'nationality' => $request->input('nationality'),
        //     'marital_status' => $request->input('marital_status'),
        //     'biography' => $request->input('biography'),
        //     'religion' => $request->input('religion'),
        //     'address' => $request->input('address'),
        //     'address2' => $request->input('address2'),
        //     'city' => $request->input('city'),
        //     'province' => $request->input('province'),
        //     'passport' => $request->input('passport'),
        //     'passport_issued_at' => $request->input('passport_issued_at'),
        //     'passport_expires_at' => $request->input('passport_expires_at'),
        //     'passport_file' => $passport_file ?? null,
        //     'nid' => $request->input('nid'),
        //     'nid_issued_at' => $request->input('nid_issued_at'),
        //     'nid_expires_at' => $request->input('nid_expires_at'),
        //     'nid_file' => $nidFile ?? null,
        //     'visa' => $request->input('visa'),
        //     'visa_issued_at' => $request->input('visa_issued_at'),
        //     'visa_expires_at' => $request->input('visa_expires_at'),
        //     'visa_file' => $visa_file ?? null,
        //     'country' => $request->input('country'),
        // ]);
        
         // Save the profile data and associate it with the user
        // $user->profile()->save($profile);

        // $jobDetail = new JobDetail([
        //     'hired_at' => $request->input('hired_at'),
        //     'joined_at' => $request->input('joined_at'),
        //     'resigned_at' => $request->input('resigned_at'),
        //     'source_of_hire' => $request->input('source_of_hire'),
        //     'job_type' => $request->input('job_type'),
        //     'status' => $request->input('status'),
        //     'education' => $request->input('education'),
        //     'work_experience' => $request->input('work_experience'),
        //     'salary' => $request->input('salary'),
        //     'iban' => $request->input('iban'),
        //     'bank_name' => $request->input('bank_name'),
        //     'bank_account_number' => $request->input('bank_account_number'),
        //     'payment_method' => $request->input('payment_method'),
        //     // 'recived_email_notification' => $request->input('recived_email_notification') ?? false,
        //     'user_id' => $user->id,
        //     'supervisor_id' => $request->input('supervisor_id'), // Assuming supervisor is a user ID
        // ]);
    
        // $jobDetail->save();

        //policies immidiatly after hiring

        // $leave_policies = LeavePolicies::where('activate','=','immediately_after_hiring')->get();
        // if (count($leave_policies) > 0){
        //     foreach ($leave_policies as $key => $value) {

        //         $role = $value->roles;
        //         $gender = $value->gender;
        //         $marital_status = $value->marital_status;
        //         $user_role = Role::find($request->input('role'));

        //         if ($role === NULL) {
        //             $role = $user_role->title;
                    
        //         }
        //         if ($gender === NULL) {
        //             $gender = $user->profile->gender;
                    
        //         }
        //         if ($marital_status === NULL) {
        //             $marital_status = $user->profile->marital_status;
        //         }
                
        //         if( $role == $user_role->title and $gender == $user->profile->gender and $marital_status == $user->profile->marital_status){
        //             LeaveEntitlement::create(
        //                 [
        //                     'leave_policy_id' => $value->id,
        //                     'leave_year' => "current",
        //                     'days' => $value->days ,
        //                     'user_id' => $user->id,
        //                 ]
        //             );
                    
        //         }
        //     }
        // }
    
        return redirect('admin/users');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::with('roles','profile','jobDetail')->find($id);
        $data['page_title'] = 'User Detail';
        $data['user'] = $user;
        return view('admin/users/show',$data);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user=User::with('roles')->findOrFail($id);
        $supervisors = User::all();

        $roles = Role::all();
        
        if(is_null($user))
        {
            return redirect('user');
        }
        $data = compact('user','roles','supervisors');
      
        return view('admin/users/edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
            $user = User::findOrFail($id);

            $validation = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                "supervisor_id" => 'required',
                // 'email' => 'required|email|unique:users,email',
                'role' => 'required',
                'date_of_birth' => 'required',
                'phone' => 'required',
                'gender' => 'required',
                'marital_status' => 'required',
                'nationality' => 'required',
                'religion' => 'required',
                'passport' => 'required',
                'passport_issued_at' => 'required',
                'passport_expires_at' => 'required',
                // 'passport_file' => 'required | mimes:pdf',
                
                'nid' => 'required',
                'nid_issued_at' => 'required',
                'nid_expires_at' => 'required',
                // 'nid_file' => 'required | mimes:pdf',

                'visa' => 'required',
                'visa_issued_at' => 'required',
                'visa_expires_at' => 'required',
                // 'visa_file' => 'required | mimes:pdf',

                'hired_at' => 'required',
                'address' => 'required',
                'city' => 'required',
                'source_of_hire' => 'required',
                'job_type' => 'required',
                'status' => 'required',
                'education' => 'required',
                'work_experience' => 'required',
                'salary' => 'required',
                'province' => 'required',
                'country' => 'required',
                'bank_name' => 'required',
                'bank_account_number' => 'required',
                'iban' => 'required',
                'payment_method' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);
          
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'), //
            ]);


        if ($request->hasFile('image')) {
            $fileName = $user->id . '.' . $request->image->extension();
            $request->file('image')->storeAs('public/profile_images', $fileName);
    
            // Update profile data with the new image
            $user->profile->update([
                'image' => $fileName,
            ]);
        }
        if ($request->hasFile('passport_file')) {
            $fileName = $user->id . '.' . $request->passport_file->extension();
            $request->file('passport_file')->storeAs('public/passport_files', $fileName);
    
            // Update profile data with the new image
            $user->profile->update([
                'passport_file' => $fileName,
            ]);
        }
        if ($request->hasFile('nid_file')) {
            $fileName = $user->id . '.' . $request->nid_file->extension();
            $request->file('nid_file')->storeAs('public/nid_files', $fileName);
    
            // Update profile data with the new image
            $user->profile->update([
                'nid_file' => $fileName,
            ]);
        }
        if ($request->hasFile('visa_file')) {
            $fileName = $user->id . '.' . $request->visa_file->extension();
            $request->file('visa_file')->storeAs('public/visa_files', $fileName);
    
            // Update profile data with the new image
            $user->profile->update([
                'visa_file' => $fileName,
            ]);
        }


        

        $user->jobDetail->update([
            'hired_at' => $request->input('hired_at'),
            'joined_at' => $request->input('joined_at'),
            'resigned_at' => $request->input('resigned_at'),
            'source_of_hire' => $request->input('source_of_hire'),
            'job_type' => $request->input('job_type'),
            'status' => $request->input('status'),
            'education' => $request->input('education'),
            'work_experience' => $request->input('work_experience'),
            'salary' => $request->input('salary'),
            'iban' => $request->input('iban'),
            'bank_name' => $request->input('bank_name'),
            'bank_account_number' => $request->input('bank_account_number'),
            'payment_method' => $request->input('payment_method'),
            'supervisor_id' => $request->input('supervisor_id'), // Assuming supervisor is a user ID
            // 'recived_email_notification' => $request->input('recived_email_notification') ?? false,
            // 'supervisor' => $request->input('supervisor'), // Assuming supervisor is a user ID
        ]);

        
        

        $user->roles()->sync([$request->input('role')]);

        return redirect('admin/users');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        User::find($id)->delete();
        return redirect('admin/users');

    }

    public function massAction(Request $request)
    {
        $massAction = $request['massAction'];
        $actionType = $request['action_type'];
        
        if($actionType == 'restoreAll'){

            foreach ($massAction as $id) {

            User::withTrashed()->find($id)->restore();
            
        }
        return redirect('admin/users?trash=1');
        }

        if($actionType == 'forceDestroyAll'){

        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
            foreach ($massAction as $id) {

                User::withTrashed()->find($id)->forceDelete();
                
            }
            return redirect('admin/users?trash=1');
            
        }
        
        if($actionType == 'destroyAll'){

        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            
            foreach ($massAction as $id) {
                
                User::find($id)->delete();
            }
            return redirect('admin/users');
        }

        return redirect('admin/users');

    }

    public function restore(string $id)
    {
        //
        User::withTrashed()->find($id)->restore();
        return redirect('admin/users?trash=1');

    }
 
    public function forceDelete(string $id)
    {
        //
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::withTrashed()->find($id)->forceDelete();
        return redirect('admin/users?trash=1');

    }
}
