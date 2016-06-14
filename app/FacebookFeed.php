<?php

namespace App;

use App\RelationshipTraits\HasMedia;
use App\RelationshipTraits\InStream;
use Illuminate\Database\Eloquent\Model;

class FacebookFeed extends Model
{
    use HasMedia;

    protected $fillable = [
        "message", "message_id", "author_id", "reply_to", "created_at"
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

}
