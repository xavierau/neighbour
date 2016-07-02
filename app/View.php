<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'user_id', 'feed_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
