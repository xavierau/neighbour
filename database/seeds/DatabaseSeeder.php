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
        $this->call(CreateCategorySeeder::class);
        $this->call(CreateDefaultPermissionSeeder::class);
        $this->call(CreateRoleSeeder::class);
        $this->call(CreateUserSeeder::class);
        $this->call(UserTypesTableSeeder::class);
    }
}
