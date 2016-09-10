<?php

use App\Clan;
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
                'first_name'=>"Xavier",
                'last_name'=>"Au",
                'email'=>"xavier.au@anacreation.com",
                'password'=>"aukaiyuen",
                'city_id' => 1,
                'role'=>"dev",
                'statusCode'=>'active',
                'userType'=>'app'
            ],
            [
                'first_name'=>"Site",
                'last_name'=>"Administrator",
                'city_id' => 1,
                'email'=>"admin@admin.com",
                'password'=>"123456",
                'role'=>"sadmin",
                'statusCode'=>'active',
                'userType'=>'app'
            ],
            [
                'first_name'=>"Building",
                'last_name'=>"Administrator",
                'city_id' => 1,
                'email'=>"badmin@admin.com",
                'password'=>"123456",
                'role'=>"badmin",
                'statusCode'=>'active',
                'clan'=>"ic",
                'userType'=>'app'
            ],
            [
                'first_name'=>"Tommy",
                'last_name'=>"Li",
                'city_id' => 1,
                'email'=>"tommy@admin.com",
                'password'=>"123456",
                'role'=>"gen",
                'statusCode'=>'active',
                'clan'=>"ic",
                'userType'=>'app'
            ],
            [
                'first_name'=>"Tony",
                'last_name'=>"Lee",
                'city_id' => 1,
                'email'=>"tony@admin.com",
                'password'=>"123456",
                'role'=>"gen",
                'statusCode'=>'pending',
                'clan'=>"ic",
                'userType'=>'app'
            ],
            [
                'first_name'=>"John",
                'last_name'=>"Sin",
                'city_id' => 1,
                'email'=>"john@admin.com",
                'password'=>"123456",
                'role'=>"gen",
                'statusCode'=>'pending',
                'clan'=>"ic",
                'userType'=>'app'
            ],
            [
                'first_name'=>"Building Admin",
                'last_name'=>"s189",
                'city_id' => 2,
                'email'=>"john1@admin.com",
                'password'=>"123456",
                'role'=>"badmin",
                'statusCode'=>'active',
                'clan'=>"s189",
                'userType'=>'app'
            ],
            [
                'first_name'=>"Gen User",
                'last_name'=>"s189",
                'city_id' => 2,
                'email'=>"john2@admin.com",
                'password'=>"123456",
                'role'=>"gen",
                'statusCode'=>'active',
                'clan'=>"s189",
                'userType'=>'app'
            ],
            [
                'first_name'=>"Gen User",
                'last_name'=>"s189",
                'city_id' => 2,
                'email'=>"john3@admin.com",
                'password'=>"123456",
                'role'=>"gen",
                'statusCode'=>'pending',
                'clan'=>"s189",
                'userType'=>'app'
            ],
            [
                'first_name'=>"Building Admin",
                'last_name'=>"sum",
                'city_id' => 3,
                'email'=>"peter1@admin.com",
                'password'=>"123456",
                'role'=>"badmin",
                'statusCode'=>'active',
                'clan'=>"sum",
                'userType'=>'app'
            ],
            [
                'first_name'=>"Gen User",
                'last_name'=>"sum",
                'city_id' => 3,
                'email'=>"peter2@admin.com",
                'password'=>"123456",
                'role'=>"gen",
                'statusCode'=>'active',
                'clan'=>"sum",
                'userType'=>'app'
            ],
            [
                'first_name'=>"Gen User",
                'last_name'=>"sum",
                'city_id' => 3,
                'email'=>"peter3@admin.com",
                'password'=>"123456",
                'role'=>"gen",
                'statusCode'=>'pending',
                'clan'=>"sum",
                'userType'=>'app'
            ],

        ];

        $roles = Role::all();
        foreach ($users as $user){


            $newUser = new User();
            $newUser->first_name = $user['first_name'];
            $newUser->last_name = $user['last_name'];
            $newUser->city_id = $user['city_id'];
            $newUser->email = $user['email'];
            $newUser->password = $user['password'];
            $newUser->save();

            $role = $roles->first(function($key, $role)use($user){
                return $role->code == $user['role'];
            });
            $status = \App\UserStatus::whereCode($user['statusCode'])->first();

            if(isset($user["clan"])){
                $clan = Clan::whereCode($user["clan"])->first();
                $newUser->clan()->associate($clan);
            }
            $status = \App\UserStatus::whereCode($user['statusCode'])->first();


            $newUser->roles()->save($role);
            $newUser->status()->associate($status);
            $newUser->type()->associate(\App\UserType::whereType($user['userType'])->first());

            $newUser->save();


        }
    }
}
