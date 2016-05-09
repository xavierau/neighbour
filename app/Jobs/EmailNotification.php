<?php

namespace App\Jobs;

use App\Feed;
use App\Jobs\Job;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * Create a new job instance.
     *
     * @return void
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
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $data = [
            "feed"=>$this->feed,
        ];
        $mailer->send('emails.NewPostNotification', $data, function ($m) {
            $m->to($this->recipient->email, $this->recipient->name)
                ->from('no-reply@neighbour.app', 'Neighbour App')
                ->subject('New Post!');
        });
    }
}
