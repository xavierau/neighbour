<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
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
}
