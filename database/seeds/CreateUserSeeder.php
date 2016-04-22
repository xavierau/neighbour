<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'=>"Xavier Au",
                'email'=>"xavier.au@anacreation.com",
                'password'=>"aukaiyuen",
                'role'=>"dev",
            ],
            [
                'name'=>"Administrator",
                'email'=>"admin@admin.com",
                'password'=>"123456",
                'role'=>"sadmin",
            ],
            [
                'name'=>"Tommy",
                'email'=>"tommy@admin.com",
                'password'=>"123456",
                'role'=>"gen",
            ],
            [
                'name'=>"Tony",
                'email'=>"tony@admin.com",
                'password'=>"123456",
                'role'=>"gen",
            ],
            [
                'name'=>"John",
                'email'=>"john@admin.com",
                'password'=>"123456",
                'role'=>"gen",
            ],
        ];

        $roles = Role::all();
        foreach ($users as $user){
            $newUser = new User();
            $newUser->name = $user['name'];
            $newUser->email = $user['email'];
            $newUser->password = bcrypt($user['password']);
            $newUser->save();
            $role = $roles->first(function($key, $role)use($user){
                return $role->code == $user['role'];
            });
            $newUser->roles()->save($role);
        }
    }
}
