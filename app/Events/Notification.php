<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Notification extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $message;
    public $type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->message = $user->notificationsCount;
        $this->type = "newNotification_".$user->id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ["neighbourApp:notification"];
    }
}
