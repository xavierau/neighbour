<?php

namespace App;

use App\RelationshipTraits\HasMedia;
use App\RelationshipTraits\InStream;
use Illuminate\Database\Eloquent\Model;

class FacebookFeed extends Model
{
    use HasMedia, InStream;

    protected $fillable = [
        "message", "message_id", "author_id", "reply_to", "created_at"
    ];

}
