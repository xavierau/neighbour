<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvent extends Event
{
    use SerializesModels;
    /**
     * @type \Illuminate\Database\Eloquent\Model
     */
    public $model;
    /**
     * @type
     */
    public $action_user_id;
    /**
     * @type
     */
    public $notified_user_id;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $model, $notified_user_id, $action_user_id)
    {

        $this->model = $model;
        $this->action_user_id = $action_user_id;
        $this->notified_user_id = $notified_user_id;
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
