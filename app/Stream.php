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

    public function getStream($clanId=null, $paginateNumber = 5)
    {
        if($clanId){
            return $this->whereClanId($clanId)
                ->orderBy('created_at', "desc")
                ->with('item')
                ->paginate($paginateNumber);
        }
        return $this->orderBy('created_at', "desc")->with('item')->paginate(5);
    }
}
