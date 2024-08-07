<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'first_name'               => 'John',
                'last_name'               => 'Due',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'email_verified_at'        => '2022-06-28 21:44:12',
            ],
            [
                'id'                 => 2,
                'first_name'               => 'Sam',
                'last_name'               => 'Due',
                'email'              => 'empolyee@empolyee.com',
                'password'           => bcrypt('password'),
                'email_verified_at'        => '2022-06-28 21:44:12',
            ],
        ];

        User::insert($users);
    }
}
