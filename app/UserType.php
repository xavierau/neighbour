<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    //

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes["type"] = strtolower($value);
    }
}
