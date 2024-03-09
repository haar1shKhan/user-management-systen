<?php

namespace Database\Seeders;
use App\Models\JobDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
            [
                'user_id' => 1, 
                'salary' => 0
            ],
            [
                'user_id' => 2,
                'salary' => 0
            ],
       ];

       JobDetail::insert($data);
    }
}
