<?php

namespace App\Policies;

use App\Enums\UserStatus;
use App\Permission;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Tests\Logger;

class UserPolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct(User::class);
    }

    public function updateProfile($user, $ability) {
        return $user->id == $ability->id;
    }

    public function get(User $user, $ability, $userStatus) {
        switch ($userStatus) {
            case UserStatus::PENDING:
                $check = $user->hasPermission($this->getPermissionId('getPending'));
                break;
            default:
                $check = false;

        }
        return $check;
    }

    public function approve(User $user, $ability) {
        $permissionId = $this->getPermissionId('approve');
        Log::info($user->hasPermission($permissionId));
        Log::info($user->clan_id == $ability->clan_id);


        return $user->hasPermission($permissionId) and $user->clan_id == $ability->clan_id;
    }

    private function getPermissionId($action){

        $permissions = Cache::tags(['permission'])->rememberForever('permissions', function () {
            return Permission::all();
        });

        return $permissions
            ->where('object', User::class)
            ->where('action', $action)
            ->first()->id;
    }
}
