<?php
/**
 * Author: Xavier Au
 * Date: 10/9/2016
 * Time: 9:25 PM
 */

namespace App\Policies;


use App\Permission;
use Illuminate\Support\Facades\Cache;

class BasicPolicy
{

    protected $actions=[];

    protected $className;
    /**
     * BasicPolicy constructor.
     */
    public function __construct($className) {
        $this->className = $className;

        $permissions = Cache::rememberForever('permissions', function(){
            return Permission::all();
        });
        $this->actions = $permissions->where('object',$className)->map(function($permission){
            return $permission->action;
        })->toArray();
    }

    public function __call($methodName, $arguments) {
        if(in_array($methodName, $this->actions)){

            $user = $arguments[0];

            $permissions = Cache::tags(['permission'])->rememberForever('permissions', function(){
                return Permission::all();
            });

            $permission = $permissions->first(function($key, $permission)use($methodName){
                return $permission->object == $this->className and $permission->action == $methodName;
            });

            return $user->hasPermission($permission->id);
        };
    }

    public function before($user) {
        if($user->is('sadmin') or $user->is('dev')){
            return true;
        };
    }
}