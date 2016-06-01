<?php

namespace App;

use App\RelationshipTraits\UserRelationshipTrait;
use App\Traits\UserAuthorizationTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Class User
 * @property integer notificationsCount
 * @package App
 */
class User extends Authenticatable
{
    use UserAuthorizationTrait, UserRelationshipTrait;
    /**
     * @type string
     */
    protected $userRoleCacheKey = "user_roleArray";
    /**
     * @type string
     */
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

    protected $appends =[
        'notificationsCount'
    ];

    protected $casts =[
        "has_notification"=>'boolean'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value?$value:"/profilePic/default-user-icon-profile.png";
    }

    public function myNotifications()
    {
        return Notification::orderBy("created_at","desc")->whereNotifiedUserId($this->id)->with('user')->get();
    }
   
    public function getNotificationsCountAttribute()
    {
        return Notification::whereIsNew(true)->whereNotifiedUserId($this->id)->count();
    }

    
}
