<?php

namespace App\Policies;

use App\Like;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Like::class);
    }
}
