<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    public function item()
    {
        return $this->morphTo('item');
    }
}
