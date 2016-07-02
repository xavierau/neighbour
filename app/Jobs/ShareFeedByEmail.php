<?php

namespace App\Jobs;

use App\Event;
use App\Feed;
use App\Jobs\Job;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShareFeedByEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @type string
     */
    private $email;
    /**
     * @type String
     */
    private $type;
    /**
     * @type int
     */
    private $id;
    /**
     * @type \App\User
     */
    private $user;

    /**
     * Create a new job instance.
     * @param string    $email
     * @param \App\User $user
     * @param String    $type
     * @param int       $id
     */
    public function __construct(string $email, User $user, String $type, int $id)
    {
        $this->email = $email;
        $this->type = $type;
        $this->id = $id;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     * @throws \Exception
     */
    public function handle(Mailer $mailer)
    {

        if($this->type == 'feed'){
            $feed = Feed::findOrFail($this->id);
            $data = [
                "feed" => $feed->load(['sender', 'media'])
            ];
        }else{
            $event = Event::findOrFail($this->id);
            $data = [
                "feed" => $event->load(['organiser', 'participants'])
            ];
        }

        $email = $this->email;
        $emailDomain = substr(strrchr($email, "@"), 1);

        $dummyEmailDomains = ["dummy.com", "abc.com", "admin.com"];
        if (!in_array($emailDomain, $dummyEmailDomains)) {
            $template = $this->type == "event"?"emails.EventInvitation":"emails.ShareFeed";

            $mailer->send($template, $data, function ($m) {

                $fromAddress = $this->user->email;
                $subject = "Share with you!";
                $sender = $this->user->name;

                $m->to($this->email, $this->email)
                    ->from($fromAddress, $sender)
                    ->subject($subject);
            });
        }
    }
}
