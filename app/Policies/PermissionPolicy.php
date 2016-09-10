<?php

namespace App\Policies;

use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Permission::class);
    }
}
