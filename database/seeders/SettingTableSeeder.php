<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                "id" => 1,
                "code" => 'settings',
                "key" => 'mail_smtp_hostname',
                "value" => 'smtp.gmail.com',
            ],
            [
                "id" => 2,
                "code" => 'settings',
                "key" => 'mail_smtp_username',
                "value" => 'haarishkhan13@gmail.com',
            ],
            [
                "id" => 3,
                "code" => 'settings',
                "key" => 'mail_smtp_password',
                "value" => 'mzpqqihynwrqsihe',
            ],
            [
                "id" => 4,
                "code" => 'settings',
                "key" => 'mail_smtp_port',
                "value" => '587',
            ],
            [
                "id" => 5,
                "code" => 'settings',
                "key" => 'mail_smtp_timeout',
                "value" => '5',
            ],
            [
                "id" => 6,
                "code" => 'settings',
                "key" => 'store_name',
                "value" => 'haarish store branch 1',
            ],
            [
                "id" => 7,
                "code" => 'settings',
                "key" => 'store_owner',
                "value" => 'haarish khan',
            ],
            [
                "id" => 8,
                "code" => 'settings',
                "key" => 'store_address',
                "value" => 'murashid,fujairah',
            ],
            [
                "id" => 9,
                "code" => 'settings',
                "key" => 'store_email',
                "value" => 'haarishkhan13@gmail.com',
            ],
            [
                "id" => 10,
                "code" => 'settings',
                "key" => 'store_phone',
                "value" => '0543562678',
            ],
            [
                "id" => 11,
                "code" => 'settings',
                "key" => 'store_telephone',
                "value" => '0543562678',
            ],
            [
                "id" => 12,
                "code" => 'settings',
                "key" => 'store_latitude',
                "value" => 'Null',
            ],
            [
                "id" => 13,
                "code" => 'settings',
                "key" => 'store_longitute',
                "value" => 'Null',
            ],
            [
                "id" => 14,
                "code" => 'settings',
                "key" => 'site_icon',
                "value" => 'storage/site_images/site_icon.jpg',
            ],
            [
                "id" => 15,
                "code" => 'settings',
                "key" => 'site_logo',
                "value" => 'storage/site_images/site_logo.png',
            ],
            [
                "id" => 16,
                "code" => 'settings',
                "key" => 'mail_logo',
                "value" => 'storage/site_images/site_email.jpg',
            ],
        ];

        Setting::insert($settings);
    }
}
