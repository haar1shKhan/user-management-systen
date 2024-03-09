<?php

namespace App\Providers;
use App\Models\Setting;
use App\Models\longLeave;
use App\Models\LateAttendance;
use App\Models\ShortLeave;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('settings')) {
            
            foreach (Setting::all() as $setting) {
                Config::set($setting->code.'.'.$setting->key, $setting->value);
            }

            $smtp = [
                'mail.mailers.smtp.host' => config('settings.mail_smtp_hostname'),
                'mail.mailers.smtp.username' => config('settings.mail_smtp_username'),
                'mail.mailers.smtp.password' => config('settings.mail_smtp_password'),
                'mail.mailers.smtp.port' => config('settings.mail_smtp_port'),
                'mail.mailers.smtp.timeout' => config('settings.mail_smtp_timeout'),
                'mail.from.address' => config('settings.store_email'),
                'mail.from.name' => config('app.name'),
            ];

            Config::set($smtp);
        }

        $leave_request = longLeave::where('approved','0')->count();
        $late_request  = LateAttendance::where('approved','0')->count();
        $short_request = ShortLeave::where('approved','0')->count();
        $total_request = $leave_request + $late_request + $short_request;

        Config::set('count.leave', $leave_request);
        Config::set('count.late', $late_request);
        Config::set('count.short', $short_request);
        Config::set('count.total', $total_request);
    }
}
