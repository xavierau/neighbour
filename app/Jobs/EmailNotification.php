<?php

namespace App\Jobs;

use App\Feed;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class EmailNotification extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @type \App\Feed
     */
    private $feed;
    /**
     * @type \App\User
     */
    private $recipient;
    /**
     * @type \Illuminate\Contracts\Mail\Mailer
     */
    private $mailer;

    /**
     * Create a new job instance.
     *
     * @param \App\Feed                         $post
     * @param \App\User                         $recipient
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     */
    public function __construct(Feed $post, User $recipient)
    {
        //
        $this->feed = $post;
        $this->recipient = $recipient;
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
            "feed" => $this->feed->load(['sender', 'media']),
            "settings" => Cache::get('settings')
        ];

        $email = $this->recipient->email;
        $emailDomain = substr(strrchr($email, "@"), 1);

        $dummyEmailDomains = ["dummy.com", "abc.com", "admin.com"];

        if (!in_array($emailDomain, $dummyEmailDomains)) {
            $mailer->send('emails.NewPostNotification', $data, function ($m) {

                $fromAddress = env("MAIL_NOTIFICATION_ADDRESS");
                $subject = env("MAIL_NOTIFICATION_SUBJECT");
                $sender = env("MAIL_NOTIFICATION_SENDER");

                $m->to($this->recipient->email, $this->recipient->name)
                    ->from($fromAddress, $sender)
                    ->subject($subject);
            });
        }
    }
}
