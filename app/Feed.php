<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [
        'content','category_id','reply_to'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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
            ->with("sender")
            ->take(15);
    }
    public function scopeFeedCategory($query, $categoryCode)
    {
        return $query->whereHas("category", function($q)use($categoryCode){
            $q->where("code", $categoryCode);
        });
    }
}
