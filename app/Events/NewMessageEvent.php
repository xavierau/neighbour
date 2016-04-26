<?php

namespace App\Events;

use App\Events\Event;
use App\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessageEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @type \App\Message
     */
    public $message;

    public $type;

    /**
     * Create a new event instance.
     *
     * @param \App\Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->type = "conversation_".$this->message->conversation->id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['neighbourApp:message'];
    }
}
