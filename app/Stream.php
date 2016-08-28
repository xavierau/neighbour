<?php

namespace App;

use App\Contracts\InStream;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stream extends Model
{
    public function item()
    {
        return $this->morphTo();
    }
    public function clan()
    {
        return $this->belongsTo(Clan::class);
    }

    public static function getAllStream($clanId=null, $paginateNumber = 5)
    {
        $self = new static();
        return $self->executeQuery($self, $clanId, $paginateNumber);
    }

    private function executeQuery($query, int $clanId, int $paginateNumber) {

        $query = $clanId>0 ?
            $query->getClanStream($clanId) :
            $query->defaultFetchingSettings();
        return $query->paginate($paginateNumber);
    }

    public static function getSpecificTypeStreamOnly($className, $clanId=null, $paginateNumber = 5)
    {
        $self = new static();
        $query = $self->specificTypeStreamOnly($className);

        return $self->executeQuery($query, $clanId, $paginateNumber);
    }



    public function scopeGetClanStream($query, $clanId=null){
        return $query->whereClanId($clanId)
            ->defaultFetchingSettings();
    }

    public function scopeDefaultFetchingSettings($query) {
        return $query->orderBy('created_at', "desc")->with('item');
    }

    public function scopeSpecificTypeStreamOnly($query, string $type) {
        return $query->whereItemType($type);
    }
}
