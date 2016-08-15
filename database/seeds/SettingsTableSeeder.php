<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new \App\Setting;
        $setting->label = "App Name";
        $setting->code = "appName";
        $setting->type = "text";
        $setting->value = "LocalHood";
        $setting->save();
    }
}
