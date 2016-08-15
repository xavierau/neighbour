<?php

use App\Category;
use Illuminate\Database\Seeder;

class CreateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'=>'Public',
                'code'=>'public',
                'showInList'=>true,
                'showInPublic'=>true,
                'canSelect'=>true
            ],
            [
                'name'=>'Events',
                'code'=>'events',
                'showInList'=>false,
                'showInPublic'=>true,
                'canSelect'=>false
            ],
            [
                'name'=>'Lost and found',
                'code'=>'lostAndFound',
                'showInList'=>true,
                'showInPublic'=>true,
                'canSelect'=>true
            ],
            [
                'name'=>'Hot deals',
                'code'=>'hotDeals',
                'showInList'=>true,
                'showInPublic'=>false,
                'canSelect'=>false
            ],
            [
                'name'=>'Others',
                'code'=>'others',
                'showInList'=>true,
                'showInPublic'=>false,
                'canSelect'=>false
            ],
        ];

        foreach ($categories as $category){
            $newCategory = new Category();
            $newCategory->name =   $category['name'];
            $newCategory->showInList =   $category['showInList'];
            $newCategory->code =   $category['code'];
            $newCategory->showInPublic =   $category['showInPublic'];
            $newCategory->canSelect =   $category['canSelect'];
            $newCategory->save();
        }
    }
}
