<?php

use App\Role;
use Illuminate\Database\Seeder;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
            [
                'label'=>'Developer',
                'code'=>'dev',
            ],
            [
                'label'=>'Site Administrator',
                'code'=>'sadmin',
            ],
            [
                'label'=>'General User',
                'code'=>'gen',
            ]
        ];
        foreach ($roles as $role){
            $newRole = new Role();
            $newRole->label = $role['label'];
            $newRole->code = $role['code'];
            $newRole->save();
        }
    }
}
