<?php
/**
 * Author: Xavier Au
 * Date: 1/6/2016
 * Time: 7:00 PM
 */

namespace App\Events;




use Illuminate\Queue\SerializesModels;
use App\Event as UserEvent;

class NewEventCreated
{
    use SerializesModels;
    /**
     * @var \App\Event
     */
    public $event;


    /**
     * Create a new event instance.
     * @param \App\Event $event
     */
    public function __construct(UserEvent $event)
    {
        //
        $this->event = $event;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}