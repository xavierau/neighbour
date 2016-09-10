<?php

namespace App\Policies;

use App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Category::class);
    }


}
