<?php

namespace Database\Seeders;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
            ['user_id' => 1],
            ['user_id' => 2],
       ];

       Profile::insert($data);
    }
}
