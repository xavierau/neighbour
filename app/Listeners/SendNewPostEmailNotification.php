<?php

namespace App\Listeners;

use App\Events\NewPostCreated;
use App\Jobs\EmailNotification;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewPostEmailNotification
{
    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewPostCreated  $event
     * @return void
     */
    public function handle(NewPostCreated $event)
    {
        $recipients = User::where('email',"<>",$event->feed->sender->email)->get();
        foreach ($recipients as $recipient){
            $this->dispatch(new EmailNotification($event->feed, $recipient));
        }
    }
}
