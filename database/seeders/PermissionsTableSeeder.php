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
                "id"=> 1,
                "title"=> "User Management Access",
                "slug"=> "user_management_access"
              ],
              [
                "id"=> 2,
                "title"=> "Leave Management Access",
                "slug"=> "leave_management_access"
              ],
              [
                "id"=> 3,
                "title"=> "Leave Manager Access",
                "slug"=> "leave_manager_access"
              ],
              [
                "id"=> 4,
                "title"=> "System Access",
                "slug"=> "system_access"
              ],
              [
                "id"=> 5,
                "title"=> "Dashboard Access",
                "slug"=> "dashboard_access"
              ],
              [
                "id"=> 6,
                "title"=> "Permission Create",
                "slug"=> "permission_create"
              ],
              [
                "id"=> 7,
                "title"=> "Permission Edit",
                "slug"=> "permission_edit"
              ],
              [
                "id"=> 8,
                "title"=> "Permission Show",
                "slug"=> "permission_show"
              ],
              [
                "id"=> 9,
                "title"=> "Permission Delete",
                "slug"=> "permission_delete"
              ],
              [
                "id"=> 10,
                "title"=> "Permission Access",
                "slug"=> "permission_access"
              ],
              [
                "id"=> 11,
                "title"=> "Role Create",
                "slug"=> "role_create"
              ],
              [
                "id"=> 12,
                "title"=> "Role Edit",
                "slug"=> "role_edit"
              ],
              [
                "id"=> 13,
                "title"=> "Role Show",
                "slug"=> "role_show"
              ],
              [
                "id"=> 14,
                "title"=> "Role Delete",
                "slug"=> "role_delete"
              ],
              [
                "id"=> 15,
                "title"=> "Role Access",
                "slug"=> "role_access"
              ],
              [
                "id"=> 16,
                "title"=> "User Create",
                "slug"=> "user_create"
              ],
              [
                "id"=> 17,
                "title"=> "User Edit",
                "slug"=> "user_edit"
              ],
              [
                "id"=> 18,
                "title"=> "User Show",
                "slug"=> "user_show"
              ],
              [
                "id"=> 19,
                "title"=> "User Delete",
                "slug"=> "user_delete"
              ],
              [
                "id"=> 20,
                "title"=> "User Access",
                "slug"=> "user_access"
              ],
              [
                "id"=> 21,
                "title"=> "Short Leave Access",
                "slug"=> "short_leave_access"
              ],
              [
                "id"=> 22,
                "title"=> "Short Leave Create",
                "slug"=> "short_leave_create"
              ],
              [
                "id"=> 23,
                "title"=> "Short Leave Update",
                "slug"=> "short_leave_update"
              ],
              [
                "id"=> 24,
                "title"=> "Short Leave Show",
                "slug"=> "short_leave_show"
              ],
              [
                "id"=> 25,
                "title"=> "Short Leave Delete",
                "slug"=> "short_leave_delete"
              ],
              [
                "id"=> 26,
                "title"=> "Long Leave Access",
                "slug"=> "long_leave_access"
              ],
              [
                "id"=> 27,
                "title"=> "Long Leave Create",
                "slug"=> "long_leave_create"
              ],
              [
                "id"=> 28,
                "title"=> "Long Leave Update",
                "slug"=> "long_leave_update"
              ],
              [
                "id"=> 29,
                "title"=> "Long Leave Show",
                "slug"=> "long_leave_show"
              ],
              [
                "id"=> 30,
                "title"=> "Long Leave Delete",
                "slug"=> "long_leave_delete"
              ],
              [
                "id"=> 31,
                "title"=> "Late Attendance Access",
                "slug"=> "late_attendance_access"
              ],
              [
                "id"=> 32,
                "title"=> "Late Attendance Create",
                "slug"=> "late_attendance_create"
              ],
              [
                "id"=> 33,
                "title"=> "Late Attendance Update",
                "slug"=> "late_attendance_update"
              ],
              [
                "id"=> 34,
                "title"=> "Late Attendance Show",
                "slug"=> "late_attendance_show"
              ],
              [
                "id"=> 35,
                "title"=> "Late Attendance Delete",
                "slug"=> "late_attendance_delete"
              ],
              [
                "id"=> 36,
                "title"=> "Leave Policy Access",
                "slug"=> "leave_policy_access"
              ],
              [
                "id"=> 37,
                "title"=> "Leave Policy Create",
                "slug"=> "leave_policy_create"
              ],
              [
                "id"=> 38,
                "title"=> "Leave Policy Update",
                "slug"=> "leave_policy_update"
              ],
              [
                "id"=> 39,
                "title"=> "Leave Policy Show",
                "slug"=> "leave_policy_show"
              ],
              [
                "id"=> 40,
                "title"=> "Leave Policy Delete",
                "slug"=> "leave_policy_delete"
              ],
              [
                "id"=> 41,
                "title"=> "Leave Entitlement Access",
                "slug"=> "leave_entitlement_access"
              ],
              [
                "id"=> 42,
                "title"=> "Leave Entitlement Create",
                "slug"=> "leave_entitlement_create"
              ],
              [
                "id"=> 43,
                "title"=> "Leave Entitlement Update",
                "slug"=> "leave_entitlement_update"
              ],
              [
                "id"=> 44,
                "title"=> "Leave Entitlement Show",
                "slug"=> "leave_entitlement_show"
              ],
              [
                "id"=> 45,
                "title"=> "Leave Entitlement Delete",
                "slug"=> "leave_entitlement_delete"
              ],
              [
                "id"=> 46,
                "title"=> "Setting Access",
                "slug"=> "setting_access"
              ],
              [
                "id"=> 47,
                "title"=> "Setting Update",
                "slug"=> "setting_update"
              ],
              [
                "id"=> 48,
                "title"=> "Leave Request Access",
                "slug"=> "leave_request_access"
              ],

        ];

        Permission::insert($permissions);
    }
}