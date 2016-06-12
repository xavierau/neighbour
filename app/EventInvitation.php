<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventInvitation extends Model
{
    protected $fillable = [
        "event_id", "sender_id", "receiver_id", "status"
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
