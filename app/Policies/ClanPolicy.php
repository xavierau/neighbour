<?php

namespace App\Policies;

use App\Clan;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClanPolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Clan::class);
    }
}
