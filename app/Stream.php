<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stream extends Model
{
    public function item()
    {
        return $this->morphTo('item');
    }
    public function clan()
    {
        return $this->belongsTo(Clan::class);
    }

    public static function getStream($clanId=null, $paginateNumber = 5)
    {
        $self = new static();
        if($clanId){
            return $self->getClanStream($clanId)
                ->paginate($paginateNumber);
        }
        return $self->orderBy('created_at', "desc")->with('item')->paginate(5);
    }

    public function scopeGetClanStream($query, $clanId=null){
        return $query->whereClanId($clanId)
            ->orderBy('created_at', "desc")
            ->with('item');
    }
}
