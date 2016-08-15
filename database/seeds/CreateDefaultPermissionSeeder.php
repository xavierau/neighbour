<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class CreateDefaultPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $roles=[
        [
            'label'=>'Developer',
            'code'=>'dev',
        ],
        [
            'label'=>'Site Administrator',
            'code'=>'sadmin',
        ],
        [
            'label'=>'Building Administrator',
            'code'=>'badmin',
        ],
        [
            'label'=>'General User',
            'code'=>'gen',
        ]
    ];
    protected $permissions = [
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
        [
            'label'=>'Approve User',
            'code'=>'approveUser',
        ],
        [
            'label'=>'Suspend User',
            'code'=>'suspendUser',
        ],
        [
            'label'=>'Create Building',
            'code'=>'createBuilding',
        ],
        [
            'label'=>'Edit Building',
            'code'=>'editBuilding',
        ],
        [
            'label'=>'Delete Building',
            'code'=>'deleteBuilding',
        ],

    ];

    public function run()
    {

        $this->createPermissions();
        $this->createRoles();

        $this->assignPermissionsToDeveloper();
        $this->assignPermissionsToSiteAdministrator();
        $this->assignPermissionsToBuildingAdministrator();

    }

    private function createRoles(){

        foreach ($this->roles as $role){
            $newRole = new Role();
            $newRole->label = $role['label'];
            $newRole->code = $role['code'];
            $newRole->save();
        }
    }

    private function createPermissions(){

        foreach ($this->permissions as $permission){
            $newPermission = new \App\Permission();
            $newPermission->label = $permission['label'];
            $newPermission->code = $permission['code'];
            $newPermission->save();
        }
    }

    private function assignPermissionsToDeveloper()
    {
        $developer = Role::whereCode("dev")->first();
        $permissions = Permission::lists("id")->toArray();

        $developer->permissions()->attach($permissions);
    }

    private function assignPermissionsToSiteAdministrator()
    {
        $siteAdmin = Role::whereCode("sadmin")->first();

        $permissions = [
            [
                'code'=>'createCategory',
            ],
            [
                'code'=>'editCategory',
            ],
            [
                'code'=>'showCategory',
            ],
            [
                'code'=>'deleteCategory',
            ],
            [
                'code'=>'createFeed',
            ],
            [
                'code'=>'editFeed',
            ],
            [
                'code'=>'showFeed',
            ],
            [
                'code'=>'deleteFeed',
            ],
            [
                'code'=>'createUser',
            ],
            [
                'code'=>'editUser',
            ],
            [
                'code'=>'showUser',
            ],
            [
                'code'=>'deleteUser',
            ],
            [
                'code'=>'approveUser',
            ],
            [
                'code'=>'suspendUser',
            ],
            [
                'code'=>'createBuilding',
            ],
            [
                'code'=>'editBuilding',
            ],
            [
                'code'=>'deleteBuilding',
            ],
        ];

        $this->attachPermissionToRole($permissions, $siteAdmin);
    }

    private function assignPermissionsToBuildingAdministrator()
    {
        $siteAdmin = Role::whereCode("badmin")->first();

        $permissions = [
            [
                'code'=>'approveUser',
            ],
            [
                'code'=>'suspendUser',
            ]
        ];

        $this->attachPermissionToRole($permissions, $siteAdmin);
    }

    private function attachPermissionToRole(array $permissionArray, Role $role){

        foreach($permissionArray as $permission){
            $permissionId = Permission::whereCode($permission['code'])->first()->id;
            $role->permissions()->attach($permissionId);
        }
    }


}
