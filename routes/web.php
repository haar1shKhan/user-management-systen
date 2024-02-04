<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;

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

Route::get('/', function () {
     return redirect()->route('admin.index');
})->name('/');

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Permissions
    Route::view('index', 'view')->name('index');

    Route::resource('users', UsersController::class)->names([
        'index' => 'users',
        'create' => 'user.create',
        'show' => 'user.show',
        'store' => 'user.store',
        'edit' => 'user.edit',
        'update' => 'user.update',
        'destroy' => 'user.destroy',
    ]);
    
    Route::get('user/restore/{user}', [App\Http\Controllers\Admin\UsersController::class,'restore'])->name('user.restore');
    Route::delete('user/forceDelete/{user}', [App\Http\Controllers\Admin\UsersController::class,'forceDelete'])->name('user.forceDelete');
    Route::post('user/massAction', [App\Http\Controllers\Admin\UsersController::class,'massAction'])->name('user.massAction');
    
    //Roles
    Route::resource('roles', App\Http\Controllers\Admin\RolesController::class)->except([
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

    Route::get('roles/restore/{role}', [App\Http\Controllers\Admin\RolesController::class,'restore'])->name('role.restore');
    Route::delete('roles/forceDelete/{role}', [App\Http\Controllers\Admin\RolesController::class,'forceDelete'])->name('role.forceDelete');
    Route::post('roles/massAction', [App\Http\Controllers\Admin\RolesController::class,'massAction'])->name('role.massAction');


    //Permissions
    Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class)->except([
        'show', // If you don't have a show method in your controller
    ])->names([
        'index' => 'permissions',
        'create' => 'permission.create',
        'store' => 'permission.store',
        'edit' => 'permission.edit',
        'update' => 'permission.update',
        'destroy' => 'permission.destroy',
    ]);
    Route::post('permissions/massAction', [App\Http\Controllers\Admin\PermissionController::class,'massAction'])->name('permission.massAction');

    //feedback
    Route::resource('feedback', App\Http\Controllers\Admin\FeedbackController::class)->except([
        'create', // If you don't have a show method in your controller
        'edit', // If you don't have a show method in your controller
        'update', // If you don't have a show method in your controller
        'destroy', // If you don't have a show method in your controller
    ])->names([
        'index' => 'feedback',
        'show' => 'feedback.show',
        'store' => 'feedback.store',
    ]);

    //passport
    Route::resource('passport', App\Http\Controllers\Admin\PassportController::class)->except([
        'show', // If you don't have a show method in your controller
    ])->names([
        'index' => 'passport',
        'create' => 'passport.create',
        'store' => 'passport.store',
        'edit' => 'passport.edit',
        'update' => 'passport.update',
        'destroy' => 'passport.destroy',
    ]);

    //Leave
    Route::resource('longLeave', App\Http\Controllers\Admin\LeaveController::class)->except([
        'show', // If you don't have a show method in your controller
    ])->names([
        'index' => 'longLeave',
        'create' => 'longLeave.create',
        'store' => 'longLeave.store',
        'edit' => 'longLeave.edit',
        'update' => 'longLeave.update',
        'destroy' => 'longLeave.destroy',
    ]);

    Route::post('longLeave/massAction', [App\Http\Controllers\Admin\LeaveController::class,'massAction'])->name('longLeave.massAction');

    //Leave
    Route::resource('globalLeave', App\Http\Controllers\Admin\GlobalLeaveController::class)->except([
        'show', // If you don't have a show method in your controller
    ])->names([
        'index' => 'globalLeave',
        'create' => 'globalLeave.create',
        'store' => 'globalLeave.store',
        'edit' => 'globalLeave.edit',
        'update' => 'globalLeave.update',
        'destroy' => 'globalLeave.destroy',
    ]);

    Route::post('globalLeave/massAction', [App\Http\Controllers\Admin\LeaveController::class,'massAction'])->name('globalLeave.massAction');


    Route::resource('shortLeave', App\Http\Controllers\Admin\ShortLeaveController::class)->except([
        'show', // If you don't have a show method in your controller
    ])->names([
        'index' => 'shortLeave',
        'create' => 'shortLeave.create',
        'store' => 'shortLeave.store',
        'edit' => 'shortLeave.edit',
        'update' => 'shortLeave.update',
        'destroy' => 'shortLeave.destroy',
    ]);

    Route::resource('lateAttendance', App\Http\Controllers\Admin\LateAttendanceController::class)->except([
        'show', // If you don't have a show method in your controller
    ])->names([
        'index' => 'lateAttendance',
        'create' => 'lateAttendance.create',
        'store' => 'lateAttendance.store',
        'edit' => 'lateAttendance.edit',
        'update' => 'lateAttendance.update',
        'destroy' => 'lateAttendance.destroy',
    ]);

    Route::resource('localization/longLeave', App\Http\Controllers\Admin\localization\LocalizationLeaveController::class)->except([
        'show', // If you don't have a show method in your controller
        'create',
        'edit',
    ])->names([
        'index' => 'localization.longLeave',
        'store' => 'localization.longLeave.store',
        'update' => 'localization.longLeave.update',
        'destroy' => 'localization.longLeave.destroy',
    ]);

    Route::post('localization/longLeave/massAction', [App\Http\Controllers\Admin\localization\LocalizationLeaveController::class,'massAction'])->name('localization.longLeave.massAction');

    Route::resource('leaveSettings/policies', App\Http\Controllers\Admin\LeavePoliciesController::class)->except([
        'show', // If you don't have a show method in your controller
        'create',
        'edit',
    ])->names([
        'index' => 'leaveSettings.leavePolicies',
        'store' => 'leaveSettings.leavePolicies.store',
        'update' => 'leaveSettings.leavePolicies.update',
        'destroy' => 'leaveSettings.leavePolicies.destroy',
    ]);

    Route::post('leaveSettings/policies/massAction', [App\Http\Controllers\Admin\LeavePoliciesController::class,'massAction'])->name('leaveSettings.policies.massAction');
    
    Route::resource('leaveSettings/leaveEntitlement', App\Http\Controllers\Admin\LeaveEntitlementController::class)->except([
        'show', // If you don't have a show method in your controller
        'create',
        'edit',
    ])->names([
        'index' => 'leaveSettings.leaveEntitlement',
        'store' => 'leaveSettings.leaveEntitlement.store',
        'update' => 'leaveSettings.leaveEntitlement.update',
        'destroy' => 'leaveSettings.leaveEntitlement.destroy',
    ]);

    Route::post('leaveSettings/leaveEntitlement/massAction', [App\Http\Controllers\Admin\LeaveEntitlementController::class,'massAction'])->name('leaveSettings.leaveEntitlement.massAction');
    

    Route::resource('settings', App\Http\Controllers\Admin\SettingController::class)->except([
        'show', // If you don't have a show method in your controller
        'create',
        'edit',
        'destroy'
    ])->names([
        'index' => 'settings',
        'store' => 'setting.store',
        'update' => 'setting.update',
    ]);


    
    Route::get('maintanance/backup', [App\Http\Controllers\Admin\MaintananceController::class,'backup'])->name('backup');
    Route::get('maintanance/error-log', [App\Http\Controllers\Admin\MaintananceController::class,'error'])->name('error.log');
});

