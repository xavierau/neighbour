<?php
/**
 * Author: Xavier Au
 * Date: 1/6/2016
 * Time: 7:00 PM
 */

namespace App\Events;




use Illuminate\Queue\SerializesModels;
use App\Event;

class NewEventCreated
{
    use SerializesModels;
    /**
     * @type \App\Feed
     */
    public $event;

    /**
     * Create a new event instance.
     *
     * @param \App\Event $event
     */
    public function __construct(Event $event)
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