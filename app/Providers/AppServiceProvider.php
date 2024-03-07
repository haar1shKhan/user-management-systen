<?php

namespace App\Providers;
use App\Models\Setting;
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

    }
}
