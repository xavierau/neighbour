<?php
/**
 * Author: Xavier Au
 * Date: 27/4/2016
 * Time: 11:21 AM
 */

namespace App\Traits;


use App\Notification;

trait NotificationTrait
{

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}