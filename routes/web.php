<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register'=>false]);

Route::get('/', function () {
    return redirect()->route('admin.index');
})->name('/');


Route::prefix('admin')->name('admin.')->middleware(['auth'])->namespace('App\Http\Controllers\Admin')->group( function () {

    Route::get('/', function () {
        if(Gate::denies('leave_management_access')){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.longLeave');
    })->name('index');

    /*-------------
    |  DASHBOARD  |
    -------------*/

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    /*---------------
    |  SHORT LEAVE  |
    ---------------*/

    Route::resource('short-leave', ShortLeaveController::class)->except([
        'show',
    ])->names([
        'index' => 'short-leave',
        'create' => 'short-leave.create',
        'store' => 'short-leave.store',
        'edit' => 'short-leave.edit',
        'update' => 'short-leave.update',
        'destroy' => 'short-leave.destroy',
    ]);
    Route::post('short-leave/mass-delete', [ShortLeaveController::class,'massDelete'])->name('user.massDelete');
    
    /*-------------------
    |  LATE ATTENDANCE  |
    -------------------*/
    
    Route::resource('late-attendance', LateAttendanceController::class)->except([
        'show', 
    ])->names([
        'index' => 'lateAttendance',
        'create' => 'lateAttendance.create',
        'store' => 'lateAttendance.store',
        'edit' => 'lateAttendance.edit',
        'update' => 'lateAttendance.update',
        'destroy' => 'lateAttendance.destroy',
    ]);
    Route::post('lateAttendance/massAction', [LateAttendanceController::class,'massAction'])->name('lateAttendance.massAction');

    /*---------------
    |  GLOBAL LEAVE  |
    ----------------*/

    Route::resource('globalLeave', GlobalLeaveController::class)->except([
        'create', 
        'store', 
        'show', 
        'edit', 
    ])->names([
        'index' => 'globalLeave',
        'update' => 'globalLeave.update',
        'destroy' => 'globalLeave.destroy',
    ]);

    Route::post('globalLeave/massAction', [GlobalLeaveController::class,'massAction'])->name('globalLeave.massAction');
 
    /*------------
    |  FEEDBACK  |
    ------------*/
    
    Route::get('feedback', [FeedbackController::class, 'show'])->name('feedback');
    Route::post('feedback', [FeedbackController::class, 'send'])->name('feedback.send');
    
    /*---------
    |  USERS  |
    ---------*/

    Route::resource('users', UsersController::class)->names([
        'index' => 'users',
        'create' => 'user.create',
        'show' => 'user.show',
        'store' => 'user.store',
        'edit' => 'user.edit',
        'update' => 'user.update',
        'destroy' => 'user.destroy',
    ]);
    Route::get('user/restore/{user}', [UsersController::class,'restore'])->name('user.restore');
    Route::delete('user/forceDelete/{user}', [UsersController::class,'forceDelete'])->name('user.forceDelete');
    Route::post('user/massAction', [UsersController::class,'massAction'])->name('user.massAction');
    
    /*---------
    |  ROLES  |
    ---------*/

    Route::resource('roles', RolesController::class)->except([
        'show', 
    ])->names([
        'index' => 'roles',
        'create' => 'role.create',
        'store' => 'role.store',
        'edit' => 'role.edit',
        'update' => 'role.update',
        'destroy' => 'role.destroy',
    ]);
    Route::get('roles/{role}',function(){
        abort(404);
    });

    Route::get('roles/restore/{role}', [RolesController::class,'restore'])->name('role.restore');
    Route::delete('roles/forceDelete/{role}', [RolesController::class,'forceDelete'])->name('role.forceDelete');
    Route::post('roles/massAction', [RolesController::class,'massAction'])->name('role.massAction');

    /*---------------
    |  PERMISSIONS  |
    ---------------*/
    
    Route::resource('permissions', PermissionController::class)->except([
        'show',
    ])->names([
        'index' => 'permissions',
        'create' => 'permission.create',
        'store' => 'permission.store',
        'edit' => 'permission.edit',
        'update' => 'permission.update',
        'destroy' => 'permission.destroy',
    ]);
    Route::post('permissions/massAction', [PermissionController::class,'massAction'])->name('permission.massAction');
    
    /*------------
    |  SETTINGS  |
    ------------*/

    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    /*-------------------
    |  CHANGE PASSWORD  |
    -------------------*/

    Route::get('change-password', [ChangePasswordController::class, 'index'])->name('change-password');
    Route::put('change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');

    /*----------------
    |  USER PROFILE  |
    ----------------*/

    Route::get('account/profile', [UserProfileController::class, 'index'])->name('account.profile');
    Route::get('account/profile/edit', [UserProfileController::class, 'edit'])->name('account.profile.edit');
    Route::put('account/profile/update', [UserProfileController::class, 'update'])->name('account.profile.update');

});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
   

    //passport DISABLED
    /* Route::resource('passport', App\Http\Controllers\Admin\PassportController::class)->except([
        'show', // If you don't have a show method in your controller
    ])->names([
        'index' => 'passport',
        'create' => 'passport.create',
        'store' => 'passport.store',
        'edit' => 'passport.edit',
        'update' => 'passport.update',
        'destroy' => 'passport.destroy',
    ]); */

    //Leave
    Route::resource('longLeave', LeaveController::class)->except([
        'show', // If you don't have a show method in your controller
    ])->names([
        'index' => 'longLeave',
        'create' => 'longLeave.create',
        'store' => 'longLeave.store',
        'edit' => 'longLeave.edit',
        'update' => 'longLeave.update',
        'destroy' => 'longLeave.destroy',
    ]);

    Route::post('longLeave/massAction', [LeaveController::class,'massAction'])->name('longLeave.massAction');

    Route::resource('leaveSettings/policies', LeavePoliciesController::class)->except([
        'show', // If you don't have a show method in your controller
        'create',
        'edit',
    ])->names([
        'index' => 'leaveSettings.leavePolicies',
        'store' => 'leaveSettings.leavePolicies.store',
        'update' => 'leaveSettings.leavePolicies.update',
        'destroy' => 'leaveSettings.leavePolicies.destroy',
    ]);

    Route::post('leaveSettings/policies/massAction', [LeavePoliciesController::class,'massAction'])->name('leaveSettings.policies.massAction');
    
    Route::resource('leaveSettings/leaveEntitlement', LeaveEntitlementController::class)->except([
        'show', // If you don't have a show method in your controller
        'create',
        'edit',
    ])->names([
        'index' => 'leaveSettings.leaveEntitlement',
        'store' => 'leaveSettings.leaveEntitlement.store',
        'update' => 'leaveSettings.leaveEntitlement.update',
        'destroy' => 'leaveSettings.leaveEntitlement.destroy',
    ]);

    Route::post('leaveSettings/leaveEntitlement/massAction', [LeaveEntitlementController::class,'massAction'])->name('leaveSettings.leaveEntitlement.massAction');
    

    


    //DISABLED
    /* Route::get('maintanance/backup', [MaintananceController::class,'backup'])->name('backup');
    Route::get('maintanance/error-log', [MaintananceController::class,'error'])->name('error.log'); */
});

