<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateDefaultPermissionSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(ClanTableSeeder::class);
        $this->call(CreateCategorySeeder::class);
        $this->call(User_status_table_seeder::class);
        $this->call(UserTypesTableSeeder::class);
        $this->call(CreateUserSeeder::class);
    }
}
