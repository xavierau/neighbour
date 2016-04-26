<?php

namespace App;

use App\Traits\UserAuthorizationTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use UserAuthorizationTrait;
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

    /**
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value?$value:"/profilePic/default-user-icon-profile.png";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events(){
        return $this->hasMany(Event::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parties(){
        return $this->belongsToMany(Event::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
}
