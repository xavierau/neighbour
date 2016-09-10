<?php

namespace App\Policies;

use App\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Setting::class);
    }
}
