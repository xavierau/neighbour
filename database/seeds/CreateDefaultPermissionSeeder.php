<?php

use Illuminate\Database\Seeder;

class CreateDefaultPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'label'=>'Create Category',
                'code'=>'createCategory',
            ],
            [
                'label'=>'Edit Category',
                'code'=>'editCategory',
            ],
            [
                'label'=>'Show Category',
                'code'=>'showCategory',
            ],
            [
                'label'=>'Delete Category',
                'code'=>'deleteCategory',
            ],
            [
                'label'=>'Create Feed',
                'code'=>'createFeed',
            ],
            [
                'label'=>'Edit Feed',
                'code'=>'editFeed',
            ],
            [
                'label'=>'Show Feed',
                'code'=>'showFeed',
            ],
            [
                'label'=>'Delete Feed',
                'code'=>'deleteFeed',
            ],
            [
                'label'=>'Create User',
                'code'=>'createUser',
            ],
            [
                'label'=>'Edit User',
                'code'=>'editUser',
            ],
            [
                'label'=>'Show User',
                'code'=>'showUser',
            ],
            [
                'label'=>'Delete User',
                'code'=>'deleteUser',
            ],

        ];

        foreach ($permissions as $permission){
            $newPermission = new \App\Permission();
            $newPermission->label = $permission['label'];
            $newPermission->code = $permission['code'];
            $newPermission->save();
        }
    }
}
