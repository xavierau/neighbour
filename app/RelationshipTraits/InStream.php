<?php
/**
 * Author: Xavier Au
 * Date: 18/5/2016
 * Time: 6:44 PM
 */

namespace App\RelationshipTraits;


use App\Stream;

trait InStream
{
    public function stream()
    {
        return $this->morphMany(Stream::class, 'item');
    }
}