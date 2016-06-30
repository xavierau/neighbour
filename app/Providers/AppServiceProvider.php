<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Setting::saved(function(){
            $settings = Setting::all();
            refreshForeverCache("settings",$settings);
        });
        Setting::deleted(function(){
            $settings = Setting::all();
            refreshForeverCache("settings",$settings);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
