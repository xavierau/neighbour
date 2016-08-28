<?php
/**
 * Author: Xavier Au
 * Date: 1/6/2016
 * Time: 7:02 PM
 */

namespace App\Listeners;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class AddEventToStream
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
        $model = $event->event;
        $creator = $model->organiser;

        $clanId = $creator->clan_id == 0? 1 : $creator->clan_id;
        if($model->isPublic){
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
}