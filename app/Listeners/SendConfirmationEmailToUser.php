<?php

namespace App\Listeners;

use App\Events\UserApprovedEvent;
use App\Jobs\EmailNotification;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendConfirmationEmailToUser
{
    /**
     * @var \App\Listeners\Mailer
     */
    private $mailer;

    /**
     * Create the event listener.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        //
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserApprovedEvent  $event
     * @return void
     */
    public function handle(UserApprovedEvent $event)
    {
        $recipient = $event->user;

        $email = $recipient->email;
        $emailDomain = substr(strrchr($email, "@"), 1);

        $dummyEmailDomains = ["dummy.com", "abc.com", "admin.com"];
        $data = [
            "user"=>$recipient
        ];

        if (!in_array($emailDomain, $dummyEmailDomains)) {
            $this->mailer->send('emails.UserEmailConfirmation', $data, function ($m) use($recipient) {

                $fromAddress = env("MAIL_NOTIFICATION_ADDRESS");
                $subject = "Email Confirmation from LocalHood ";
                $sender = "LocalHood";

                $m->to($recipient->email, $recipient->name)
                    ->from($fromAddress, $sender)
                    ->subject($subject);
            });
        }
    }
}
