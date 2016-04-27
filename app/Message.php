<?php

namespace App;

use App\Events\NewMessageEvent;
use App\Traits\NotificationTrait;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use NotificationTrait;

    public static function boot()
    {
        parent::boot();

        static::created(function($message)
        {
           
        });
    }


    protected $fillable = [
        'message', "conversation_id"
    ];

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
