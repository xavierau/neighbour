<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Setting extends Model
{
    protected $fillable = [
        'label', 'code', 'type', 'value'
    ];

    public static function appName()
    {
        $object = new static();
        return $object->whereCode('appName')->first()->value;
    }
}


