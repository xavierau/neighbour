<?php

namespace App\Jobs;

use App\Event;
use App\EventInvitation;
use App\Feed;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EventInvitationEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @type \App\EventInvitation
     */
    private $invitation;

    /**
     * Create a new job instance.
     *
     * @param \App\Event $event
     * @param \App\User  $recipient
     */
    public function __construct(EventInvitation $invitation)
    {
        //
        $this->invitation = $invitation;
    }

    /**
     * Execute the job.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     * @throws \Exception
     */
    public function handle(Mailer $mailer)
    {

        $data = [
            "invitation" => $this->invitation
        ];
        $mailer->send('emails.EventInvitation', $data, function ($m) {
            $m->to($this->invitation->receiver->email, $this->invitation->receiver->name)
                ->from('no-reply@neighbour.app', $this->invitation->sender->name)
                ->subject('Invite you to join '.$this->invitation->event->name);
        });
    }
}
