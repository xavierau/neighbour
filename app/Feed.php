<?php

namespace App;

use App\RelationshipTraits\HasMedia;
use App\RelationshipTraits\InStream;
use App\RelationshipTraits\IsLikeable;
use App\Traits\NotificationTrait;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use NotificationTrait, HasMedia, IsLikeable, InStream;

    protected $fillable = [
        'content',
        'category_id',
        'reply_to',
        'created_at'
    ];

    protected $appends = [
        "numberOfComment",
        "numberOfLikes",
        "views"
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
        return $query->whereHas("category", function ($q) {
            $q->where("showInPublic", true);
        });
    }

    public function scopeTopLevelFeeds($query)
    {
        return $query->whereHas("category", function ($q) {
            $q->where("showInPublic", true);
        });
    }

    public function scopeStandardFetchSetting($query)
    {
        return $query->orderBy('created_at', "desc")
            ->with([
                "sender",
                "media",
                "category",
                "likes" => function ($query) {
                    $query->where('user_id', request()->user()->id);
                }
            ]);

    }

    public function loadStandardFetchSetting()
    {
        return $this->load([
            "sender",
            "media",
            "category",
            "likes" => function ($query) {
                $query->where('user_id', request()->user()->id);
            }
        ]);

    }

    public function scopeFeedCategory($query, $categoryCode)
    {
        return $query->whereHas("category", function ($q) use ($categoryCode) {
            $q->where("code", $categoryCode);
        });
    }

    public function getNumberOfLikesAttribute()
    {
        return $this->likes()->count();
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function getViewsAttribute()
    {
        return $this->views()->count();
    }

    public function getViews()
    {
        return $this->views()->with(["user"=>function($query){
            $query->select(["avatar", "first_name", "last_name","id"]);
        }])->select("id", "user_id")->get();
    }

    public function scopeDeleteComment($query, $postId, $commentId)
    {
        $feed = $query->whereReplyTo($postId)->whereId($commentId)->first();
        if ($feed) {
            $feed->delete();
        }
    }

    public function scopeDeleteFeed($query, $feedId)
    {
        $feed = $query->find($feedId);
        if ($feed->reply_to == 0) {
            $class = get_class($feed);
            $stream = Stream::whereItemType($class)
                ->whereItemId($feed->id)
                ->first();
            $stream->delete();
        }
        $feed->delete();
    }

}
