<?php

use Illuminate\Database\Seeder;

class User_status_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                "label"=>"Pending",
                "code"=>\App\Enums\UserStatus::PENDING,
            ],[
                "label"=>"Active",
                "code"=>\App\Enums\UserStatus::ACTIVE,
            ],[
                "label"=>"Suspended",
                "code"=>\App\Enums\UserStatus::SUSPEND,
            ],[
                "label"=>"New",
                "code"=>\App\Enums\UserStatus::NEW,
            ]
        ];

        foreach ($status as $data ){
            \App\UserStatus::create($data);
        }

    }
}
