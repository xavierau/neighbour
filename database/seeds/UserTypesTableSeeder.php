<?php

use App\Enums\UserType as UT;
use App\UserType;
use Illuminate\Database\Seeder;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            array(
                "label"=>"Facebook",
                "type"=> UT::FACEBOOK
            ),
            [
                "label"=>"Google",
                "type"=> UT::GOOGLE
            ],
            [
                "label"=>"Twitter",
                "type"=> UT::TWITTER
            ],
            [
                "label"=>"App",
                "type"=> UT::APP
            ],
        ];

        foreach ($types as $type){
            $userType = new UserType();
            $userType->label = $type["label"];
            $userType->type = $type["type"];
            $userType->save();
        }


    }
}
