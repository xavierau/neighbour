<?php

namespace App;

use App\RelationshipTraits\UserRelationshipTrait;
use App\Traits\UserAuthorizationTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


/**
 * Class User
 * @property integer notificationsCount
 * @package App
 */
class User extends Authenticatable
{
    use UserRelationshipTrait;
//    use Authorizable;
//    use UserAuthorizationTrait;

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
        'first_name',
        'last_name',
        'clan_id',
        'city_id',
        'user_type_id',
        'last_name',
        'email',
        'password',
        'avatar'
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
        'notificationsCount',
        'canApproveUser'
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
        $result = $value ? $value : "/profilePic/default-user-icon-profile.png";

        return filter_var($result, FILTER_VALIDATE_URL) ? $result: url($result);
    }

    public function myNotifications()
    {
        return Notification::orderBy("created_at","desc")->whereNotifiedUserId($this->id)->with('user')->get();
    }
   
    public function getNotificationsCountAttribute()
    {
        return Notification::whereIsNew(true)->whereNotifiedUserId($this->id)->count();
    }

    public function getCanApproveUserAttribute()
    {
        return $this->can("approve", $this);
    }

    static function getPendingUsers($clanId = null){
        $pendingStatusId = \App\UserStatus::whereCode("pending")->first()->id;

        $self = new self();

        $query =  $self::whereUserStatusId($pendingStatusId)->select("id", "first_name", "last_name", "email","clan_id");

        if ($clanId){
            return $query
                ->whereClanId($clanId)
                ->get();
        }
        return $query
                ->with(["clan"=>function($query){
                    return $query->select("label","id");
                }])->get();
    }

    public function scopeGetOtherClanMembers($query)
    {
        return $query->whereClanId($this->clan_id)->where("id","<>", $this->id);
    }

    public function scopeGetOtherActiveClanMembers($query)
    {
        return $query->getOtherClanMembers()->whereUserStatusId(UserStatus::whereCode("active")->first()->id);

    }

    public function is($roleCode) {

        $userRoleCodes = Cache::tags(['role'])->rememberForever('user_roleCodes_'.$this->id, function(){
            return  $this->roles->lists('code')->toArray();
        });
        return in_array($roleCode, $userRoleCodes);
    }

    public function hasPermission($permissionId) {

        $key = "user_permissions_".$this->id;

        $permissionIds = Cache::tags(['permission', 'role'])->remember($key, 10, function(){
            $permissionIds = [];
            $permissionArray = $this->roles()->with('permissions')->get()->map(function($role)use($permissionIds){
                return array_merge($permissionIds, $role->permissions()->lists('id')->toArray());
            })->toArray();
            if (count($permissionArray) > 0)
                $permissionIds = $permissionArray[0];
            return $permissionIds;
        });

        return in_array($permissionId, $permissionIds);
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getFullNameAttribute() {
        return $this->first_name." ".$this->last_name;
    }
}
