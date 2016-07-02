<?php
/**
 * Author: Xavier Au
 * Date: 19/5/2016
 * Time: 10:24 AM
 */

namespace App\RelationshipTraits;


use App\Clan;
use App\Conversation;
use App\Event;
use App\Feed;
use App\Like;
use App\Message;
use App\Notification;
use App\Role;
use App\UserType;
use App\View;

trait UserRelationshipTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
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

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function clan()
    {
        return $this->belongsTo(Clan::class);
    }

    public function type()
    {
        return $this->belongsTo(UserType::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

}