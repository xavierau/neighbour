<?php
/**
 * Author: Xavier Au
 * Date: 19/4/2016
 * Time: 5:41 PM
 */

namespace App\Traits;


use App\Permission;
use Illuminate\Support\Facades\Cache;

trait UserAuthorizationTrait
{
    protected function getUserRoleCodeCollection(){

        $roleCodes = $this->roles()->lists("code");

        return $roleCodes;

    }

    protected function getPermissionRoleCodeCollection($permissionCode){
        $permissionObject = Permission::whereCode($permissionCode)->firstOrFail();
        $permissionRoleCodes = $permissionObject->roles()->lists("code");
        return $permissionRoleCodes;
    }

    public function can($permissionCode, $arguments = [])
    {
        $userRoleCodes = $this->getUserRoleCodeCollection();
        $permissionRoles = $this->getPermissionRoleCodeCollection($permissionCode);
        return count(array_intersect($userRoleCodes->toArray(), $permissionRoles->toArray())) > 0;
    }

    public function cannot($permissionCode, $arguments = [])
    {
        return ! $this->can($permissionCode);
    }

    public function is($roleCode)
    {
        $roleCodes = $this->roles()->lists('code')->toArray();
        return in_array($roleCode, $roleCodes);
    }

    public function isNot($role)
    {
        return !$this->is($role);
    }
}