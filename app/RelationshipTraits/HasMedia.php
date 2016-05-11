<?php
/**
 * Author: Xavier Au
 * Date: 10/5/2016
 * Time: 7:25 PM
 */

namespace App\RelationshipTraits;


use App\Media;

trait HasMedia
{
    public function media()
    {
        return $this->morphMany(Media::class, 'owner');
    }
}