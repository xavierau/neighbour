<?php

namespace App\Events;

use App\Events\Event;
use App\Feed;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewPostCreated extends Event
{
    use SerializesModels;
    /**
     * @type \App\Feed
     */
    public $feed;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Feed $feed)
    {
        //
        $this->feed = $feed;
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
