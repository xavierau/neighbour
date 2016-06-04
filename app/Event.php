<?php

namespace App;

use App\RelationshipTraits\HasMedia;
use App\RelationshipTraits\InStream;
use App\RelationshipTraits\IsLikeable;
use App\Traits\NotificationTrait;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use NotificationTrait, InStream, HasMedia, IsLikeable;

    protected $fillable=[
      'name', 'location', 'startDateTime', 'endDateTime', 'pic', 'isPublic', "description"
    ];

    public function organiser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }

    public function numberOfParticipants()
    {
        return $this->participants()->count();
    }

    public function loadStandardFetchSetting()
    {
        return $this->load(["organiser", "media", "likes"=>function($query){
            $query->where('user_id', request()->user()->id);
        },"participants"=>function($query){
            $query->lists('user_id')->toArray();
        }]);

    }
}
