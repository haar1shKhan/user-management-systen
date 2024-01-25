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
                'title' => 'user_management_access',
                'slug' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
                'slug' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
                'slug' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
                'slug' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
                'slug' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
                'slug' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
                'slug' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
                'slug' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
                'slug' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
                'slug' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
                'slug' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
                'slug' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
                'slug' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
                'slug' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
                'slug' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
                'slug' => 'user_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
