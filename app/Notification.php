<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $appends = [
        "notifiableObject"
    ];

    protected $casts=[
        "is_new" => "boolean"
    ];

    protected $fillable = [
        'user_id',
        'notified_user_id'
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNotifiableObjectAttribute()
    {
        return $this->notifiable;
    }
}