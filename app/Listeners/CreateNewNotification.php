<?php

namespace App\Listeners;

use App\Events\NotificationEvent;
use App\User;

class CreateNewNotification
{
    /**
     * @type \App\User
     */
    private $user;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  NotificationEvent $event
     * @return void
     */
    public function handle(NotificationEvent $event)
    {
        $user = $this->user->findOrFail($event->notified_user_id);
        $user->has_notification = true;
        $user->save();
        $data = [
            "user_id"          => $event->action_user_id,
            "notified_user_id" => $event->notified_user_id
        ];
        if (method_exists($event->model, "notifications")) {
            $event->model->notifications()->create($data);
        }
    }
}
