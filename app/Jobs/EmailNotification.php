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
        $this->recipient = User::whereEmail('xavier.au@gmail.com')->first();
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
            "feed"=>$this->feed->load(['sender','media'])
        ];

        $mailer->send('emails.NewPostNotification', $data, function ($m) {
            $m->to($this->recipient->email, $this->recipient->name)
                ->from('no-reply@neighbour.app', 'Neighbour App')
                ->subject('New Post!');
        });
     }
}
