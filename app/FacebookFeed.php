<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookFeed extends Model
{
    protected $fillable = [
        "message", "message_id", "author_id", "reply_to"
    ];

}
