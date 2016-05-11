<?php

namespace App;

use App\RelationshipTraits\HasMedia;
use App\Traits\NotificationTrait;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use NotificationTrait, HasMedia;
    
    protected $fillable = [
        'content','category_id','reply_to'
    ];

    protected $appends = [
        "numberOfComment"
    ];


    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getNumberOfCommentAttribute()
    {
        return $this->whereReplyTo($this->id)->count();
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = nl2br($value);
    }

    public function scopePublicShown($query)
    {
        return $query->whereHas("category", function($q){
                $q->where("showInPublic", true);
        });
    }
    public function scopeStandardFetchSetting($query)
    {
        return $query->orderBy('created_at',"desc")
            ->where("reply_to",0)
            ->with(["sender", "media"])
            ->take(15);
    }
    public function scopeFeedCategory($query, $categoryCode)
    {
        return $query->whereHas("category", function($q)use($categoryCode){
            $q->where("code", $categoryCode);
        });
    }
}
