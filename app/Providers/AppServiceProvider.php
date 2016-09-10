<?php

namespace App\Providers;

use App\Permission;
use App\Role;
use App\Setting;
use Illuminate\Support\Facades\Cache;
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

        Permission::saved(function(){
            Cache::tags('permission')->flush();
        });
        Permission::deleted(function(){
            Cache::tags('permission')->flush();
        });
        Role::saved(function(){
            Cache::tags('role')->flush();
        });
        Role::deleted(function(){
            Cache::tags('role')->flush();
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
