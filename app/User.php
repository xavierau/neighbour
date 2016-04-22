<?php

namespace App;

use App\Traits\UserAuthorizationTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use UserAuthorizationTrait;
    protected $userRoleCacheKey = "user_roleArray";
    protected $permissionRoleCacheKey = "permission_roleArray";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAvatarAttribute($value)
    {
        return $value?$value:"/profilePic/default-user-icon-profile.png";
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }
    public function events(){
        return $this->hasMany(Event::class);
    }

    public function parties(){
        return $this->belongsToMany(Event::class);
    }
    
}
