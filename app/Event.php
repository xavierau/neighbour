<?php

namespace App;

use App\Contracts\InStream as InStreamInterface;
use App\RelationshipTraits\HasMedia;
use App\RelationshipTraits\InStream;
use App\RelationshipTraits\IsLikeable;
use App\Traits\NotificationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Event extends Model implements InStreamInterface
{
    use NotificationTrait, InStream, HasMedia, IsLikeable;

    protected $fillable=[
      'name', 'location', 'startDateTime', 'endDateTime', 'pic', 'isPublic', "description", "status"
    ];

    protected $dates = [
      "created_at", "updated_at", "startDateTime", "endDateTime"
    ];

    protected $appends =[
      "eventStatus", "numberWhoAreGoing"
    ];

    public function organiser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class)->withPivot('status')->withTimestamps();
    }

    public function numberOfParticipants()
    {
        return $this->participants()->count();
    }

    public function getEventStatusAttribute()
    {
        $user = $this->participants()->whereUserId(Auth::user()->id)->first();
        if($user)
            return $user->pivot->status;
            else
                return null;
    }
    public function getNumberWhoAreGoingAttribute()
    {
        return  $this->participants()->count();
    }

    public function loadStandardFetchSetting()
    {
        return $this->load(["organiser", "media", "likes"=>function($query){
            $query->where('user_id', request()->user()->id);
        }]);

    }

    public function scopeDefaultQuery($query) {
        return $query->with(['media', "invitations"])->orderBy('created_at', 'desc');
    }

    public function invitations()
    {
        return $this->hasMany(EventInvitation::class);
    }

    public function scopeGetOthersPublicEvents($query, $myUser) {
        return $query->join('users', 'users.id', '=', 'events.user_id')
            ->where('isPublic', 1)
            ->where('user_id', "<>", $myUser->id)
            ->where('users.clan_id', "=", $myUser->cland_id)
            ->with('media')
            ->orderBy('events.created_at', 'desc');
    }

}
