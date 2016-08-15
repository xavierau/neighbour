<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    protected $fillable =[
        "label", "code"
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function stream()
    {
        return $this->hasMany(Stream::class);
    }
}
