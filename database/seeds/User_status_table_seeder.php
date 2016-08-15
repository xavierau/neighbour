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
                "code"=>"pending",
            ],[
                "label"=>"Active",
                "code"=>"active",
            ],[
                "label"=>"Suspended",
                "code"=>"suspended",
            ],[
                "label"=>"New",
                "code"=>"new",
            ]
        ];

        foreach ($status as $data ){
            \App\UserStatus::create($data);
        }

    }
}
