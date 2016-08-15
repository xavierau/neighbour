<?php

use Illuminate\Database\Seeder;

class ClanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
          [
              "label"=>"Island Crest",
              "code"=>"ic"
          ],
          [
              "label"=>"Soho 189",
              "code"=>"s189"
          ],
          [
              "label"=>"Summa",
              "code"=>"sum"
          ]
        ];

        foreach ($data as $clan){
            \App\Clan::create($clan);
        }
    }
}
