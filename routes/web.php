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
    
    /*--------------
    |  LONG LEAVE  |
    --------------*/

    Route::resource('long-leave', LeaveController::class)->except([
        'show', 
    ])->names([
        'index' => 'longLeave',
        'create' => 'longLeave.create',
        'store' => 'longLeave.store',
        'edit' => 'longLeave.edit',
        'update' => 'longLeave.update',
        'destroy' => 'longLeave.destroy',
    ]);

    Route::controller(LeaveController::class)->prefix('long-leave')->name('longLeave.')->group(function () {
        Route::put('approve/{leave}', 'approve')->name('approve');
        Route::put('pending/{leave}', 'pending')->name('pending');
        Route::put('reject/{leave}', 'reject')->name('reject');
    });

    Route::get('longLeave/print_leave/{leave}',[LeaveController::class,'print'])->name('longLeave.print');
    Route::post('longLeave/massAction', [LeaveController::class,'massAction'])->name('longLeave.massAction');

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
    Route::controller(ShortLeaveController::class)->prefix('short-leave')->name('short-leave.')->group(function () {
        Route::put('approve/{leave}', 'approve')->name('approve');
        Route::put('pending/{leave}', 'pending')->name('pending');
        Route::put('reject/{leave}', 'reject')->name('reject');
    });
    Route::get('short-leave/print_leave/{leave}',[ShortLeaveController::class,'print'])->name('short-leave.print');
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
    Route::controller(LateAttendanceController::class)->prefix('late-attendance')->name('lateAttendance.')->group(function () {
        Route::put('approve/{leave}', 'approve')->name('approve');
        Route::put('pending/{leave}', 'pending')->name('pending');
        Route::put('reject/{leave}', 'reject')->name('reject');
    });

    Route::get('late-attendance/print_leave/{leave}',[LateAttendanceController::class,'print'])->name('lateAttendance.print');
    Route::post('late-attendance/mass-action', [LateAttendanceController::class,'massAction'])->name('lateAttendance.massAction');

    /*---------------
    |  GLOBAL LEAVE  |
    ----------------*/

    Route::resource('leave-requests', GlobalLeaveController::class)->except([
        'create', 
        'store', 
        'show', 
        'edit', 
    ])->names([
        'index' => 'leave.requests',
        'update' => 'leave.requests.update',
        'destroy' => 'leave.requests.destroy',
    ]);

    Route::post('globalLeave/massAction', [GlobalLeaveController::class,'massAction'])->name('globalLeave.massAction');
 
    /*----------------
    |  LEAVE POLICY  |
    ----------------*/

    Route::resource('leaveSettings/policies', LeavePoliciesController::class)->except([
        'show',
        'create',
        'edit',
    ])->names([
        'index' => 'leaveSettings.leavePolicies',
        'store' => 'leaveSettings.leavePolicies.store',
        'update' => 'leaveSettings.leavePolicies.update',
        'destroy' => 'leaveSettings.leavePolicies.destroy',
    ]);

    Route::post('leaveSettings/policies/massAction', [LeavePoliciesController::class,'massAction'])->name('leaveSettings.policies.massAction');
    
    /*---------------------
    |  LEAVE ENTITLEMENT  |
    ---------------------*/

    Route::resource('leaveSettings/leaveEntitlement', LeaveEntitlementController::class)->except([
        'show',
        'create',
        'edit',
    ])->names([
        'index' => 'leaveSettings.leaveEntitlement',
        'store' => 'leaveSettings.leaveEntitlement.store',
        'update' => 'leaveSettings.leaveEntitlement.update',
        'destroy' => 'leaveSettings.leaveEntitlement.destroy',
    ]);

    Route::post('leaveSettings/leaveEntitlement/massAction', [LeaveEntitlementController::class,'massAction'])->name('leaveSettings.leaveEntitlement.massAction');

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
    Route::post('user/storeLongLeave/{user}', [UsersController::class,'storeLongLeave'])->name('user.store_long_leave');
    Route::post('user/storeEntitlement/{user}', [UsersController::class,'storeEntitlement'])->name('user.store_entitlement');
    Route::post('user/send-reset-email/{user}', [UsersController::class,'sendResetEmailToUser'])->name('user.reset_password');

    
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
    
    Route::get('roles/role/duplicate/', [RolesController::class,'duplicateUser'])->name('role.duplicate');
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

//Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
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

    //DISABLED
    /* Route::get('maintanance/backup', [MaintananceController::class,'backup'])->name('backup');
    Route::get('maintanance/error-log', [MaintananceController::class,'error'])->name('error.log'); */
//});

