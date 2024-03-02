<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'User Management Access',
                'slug' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'Permission Create',
                'slug' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'Permission Edit',
                'slug' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'Permission Show',
                'slug' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'Permission Delete',
                'slug' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'Permission Access',
                'slug' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'Role Create',
                'slug' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'Role Edit',
                'slug' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'Role Show',
                'slug' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'Role Delete',
                'slug' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'Role Access',
                'slug' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'User Create',
                'slug' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'User Edit',
                'slug' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'User Show',
                'slug' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'User Delete',
                'slug' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'User Access',
                'slug' => 'user_access',
            ],
            //Short Leave Access
            [
                'id' => 17,
                'title' => 'Short Leave Access',
                'slug' => 'short_leave_access',
            ],
            [
                'id' => 18,
                'title' => 'Short Leave Create',
                'slug' => 'short_leave_create',
            ],
            [
                'id' => 19,
                'title' => 'Short Leave Update',
                'slug' => 'short_leave_update',
            ],
            [
                'id' => 20,
                'title' => 'Short Leave Show',
                'slug' => 'short_leave_show',
            ],
            [
                'id' => 21,
                'title' => 'Short Leave Delete',
                'slug' => 'short_leave_delete',
            ],
            //Long Leave Access
            [
                'id' => 17,
                'title' => 'Long Leave Access',
                'slug' => 'long_leave_access',
            ],
            [
                'id' => 18,
                'title' => 'Long Leave Create',
                'slug' => 'long_leave_create',
            ],
            [
                'id' => 19,
                'title' => 'Long Leave Update',
                'slug' => 'long_leave_update',
            ],
            [
                'id' => 20,
                'title' => 'Long Leave Show',
                'slug' => 'long_leave_show',
            ],
            [
                'id' => 21,
                'title' => 'Long Leave Delete',
                'slug' => 'long_leave_delete',
            ],
            //Late Late Attendance
            [
                'id' => 17,
                'title' => 'Late Attendance Access',
                'slug' => 'late_attendance_access',
            ],
            [
                'id' => 18,
                'title' => 'Late Attendance Create',
                'slug' => 'late_attendance_create',
            ],
            [
                'id' => 19,
                'title' => 'Late Attendance Update',
                'slug' => 'late_attendance_update',
            ],
            [
                'id' => 20,
                'title' => 'Late Attendance Show',
                'slug' => 'late_attendance_show',
            ],
            [
                'id' => 21,
                'title' => 'Late Attendance Delete',
                'slug' => 'late_attendance_delete',
            ],

        ];

        Permission::insert($permissions);
    }
}
