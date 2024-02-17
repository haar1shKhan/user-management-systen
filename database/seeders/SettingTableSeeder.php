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
                "value" => 'Null',
            ],
            [
                "id" => 2,
                "code" => 'settings',
                "key" => 'mail_smtp_username',
                "value" => 'Null',
            ],
            [
                "id" => 3,
                "code" => 'settings',
                "key" => 'mail_smtp_password',
                "value" => 'Null',
            ],
            [
                "id" => 4,
                "code" => 'settings',
                "key" => 'mail_smtp_port',
                "value" => 'Null',
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
                "value" => 'Null',
            ],
            [
                "id" => 7,
                "code" => 'settings',
                "key" => 'store_owner',
                "value" => 'Null',
            ],
            [
                "id" => 8,
                "code" => 'settings',
                "key" => 'store_address',
                "value" => 'Null',
            ],
            [
                "id" => 9,
                "code" => 'settings',
                "key" => 'store_email',
                "value" => 'Null',
            ],
            [
                "id" => 10,
                "code" => 'settings',
                "key" => 'store_phone',
                "value" => 'Null',
            ],
            [
                "id" => 11,
                "code" => 'settings',
                "key" => 'store_telephone',
                "value" => 'Null',
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
        ];

        Setting::insert($settings);
    }
}
