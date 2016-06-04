<?php

namespace App\Http\Controllers;

use App\Event;
use App\Events\NewEventCreated;
use App\Http\Requests;
use App\Services\MediaServices;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class EventsController extends Controller
{
    public function getEvents(Request $request)
    {
        $myEvents = Event::whereUserId($request->user()->id)->with('media')->get();
        $publicEvents = Event::where('isPublic', 1)
                            ->where('user_id',"<>", $request->user()->id)
                            ->with('media')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return response()->json(["myEvents" => $myEvents, 'publicEvents'=>$publicEvents]);
    }

    public function getEvent($eventId)
    {
        $event = Event::find($eventId);
        return response()->json(['event'=>$event, 'numberOfParticipants'=>$event->numberOfParticipants()]);
    }

    public function postEvent(Request $request)
    {
        $data = $request->all();
        if($data['startHour']){
            if($data['startMin']){
                $time = ($data['startHour'].":".$data['startMin']);
            }else{
                $time = ($data['startHour'].":00");
            }
        }else{
            $time = "00:00";
        }
        $data["startDateTime"] = $data['startDate']." ".$time;

        if($data['endHour']){
            if($data['endMin']){
                $time = ($data['endHour'].":".$data['endMin']);
            }else{
                $time = ($data['endHour'].":00");
            }
        }else{
            $time = "00:00";
        }
        $data["endDateTime"] = $data['endDate']." ".$time;

        
        $event = $request->user()->events()->create($data);

        $files = array_filter($request->all(), function($entry){
            return $entry instanceof UploadedFile;
        });

        if(count($files)>0){
            $mediaService = new MediaServices();
            foreach ($files as $file){
                $link = $mediaService->storeFeedPhoto($file);
                $data =[
                    'link'=>$link,
                    'type'=>'image'
                ];
                $event->media()->create([])->update($data);
            }
        }

//        $event = $request->user()->events()->create($request->all());
        event(new NewEventCreated($event));
        return response()->json(["event" => $event]);
    }

    public function joinEvent(Request $request)
    {
        // get the event
        // get the request user
        // if the event participant don't have the user then add thim
        
        $event = Event::findOrFail($request->get("eventId"));
        $eventParticianptIds = $event->participants()->lists("user_id")->toArray();
        if(!in_array($request->user()->id, $eventParticianptIds)){
            $event->participants()->attach($request->user()->id);
        }
        
        $list = $request->user()->events()->lists('id')->toArray();
        $eventId = $request->get("eventId");

        if (!in_array($eventId, $list)) {
            $request->user()->parties()->attach($eventId);
        }

        return response()->json(['status' => 'completed', 'eventId'=>$eventId]);
    }
}
