<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    protected $fillable =[
        'id', 'name', 'email', 'avatar', 'avatar_original', 'gender'
    ];
}