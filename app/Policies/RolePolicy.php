<?php

namespace App\Policies;

use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Role::class);

    }
}
