<?php
/**
 * Author: Xavier Au
 * Date: 18/5/2016
 * Time: 2:18 PM
 */

namespace App\RelationshipTraits;


use App\Like;

trait IsLikeable
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}