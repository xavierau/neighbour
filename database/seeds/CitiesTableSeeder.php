<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                "label"=>"Hong Kong",
                "code"=>"HK"
            ]
        ];

        foreach ($cities as $city){
            $newCity = new \App\City();
            $newCity->label = $city['label'];
            $newCity->code = $city['code'];
            $newCity->save();
        }
    }
}
