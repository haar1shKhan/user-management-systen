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
            //Config::set('mail.mailers.smtp.password', Config::get('settings.mail_smtp_password'));
        }

    }
}
