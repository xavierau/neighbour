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
    protected function getUserRoleCodeArray(){
        $key = $this->userRoleCacheKey."_".$this->id;

        return Cache::rememberForever($key, function(){
            return $this->roles()->lists("code");
        });
    }

    protected function getPermissionRoleCodeArray($permissionCode){
        $key = $this->permissionRoleCacheKey."_".$permissionCode;
        $permissionObject = Permission::whereCode($permissionCode)->firstOrFail();
        return Cache::rememberForever($key, function()use($permissionObject){
            return $permissionObject->roles()->lists('code');
        });
    }

    public function can($permissionCode, $arguments = [])
    {
        $userRoleCodes = $this->getUserRoleCodeArray();
        $permissionRoles = $this->getPermissionRoleCodeArray($permissionCode);
        return count(array_intersect($userRoleCodes, $permissionRoles)) > 0;
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