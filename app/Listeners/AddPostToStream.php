<?php

namespace App\Listeners;

use App\Clan;
use App\Events\NewPostCreated;
use App\Feed;
use App\Jobs\EmailNotification;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class AddPostToStream
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
     * @param $event
     */
    public function handle($event)
    {
        $model = $event->feed;
        $creator = $model->sender;
        $clanId = $creator->clan_id == 0? 1 : $creator->clan_id;
        if(method_exists($model, "stream")){
            $stream =$model->stream()->create([]);
            $stream->item_id = $model->id;
            $stream->clan_id = $clanId;
            $stream->save();
        }else{
            throw new MethodNotFoundException("The Model doesn't have stream method", get_class($model), "stream");
        }
    }
}
