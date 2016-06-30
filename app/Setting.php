<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Setting extends Model
{
    protected $fillable = [
        'label', 'code', 'type', 'value'
    ];
}


