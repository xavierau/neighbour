<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function getEvents(Request $request)
    {
        $myEvents = Event::whereUserId($request->user()->id)->get();
        $publicEvents = Event::where('isPublic', 1)
                            ->where('user_id',"<>", $request->user()->id)
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
        $event = $request->user()->events()->create($request->all());

        return response()->json(["event" => $event]);
    }

    public function joinEvent(Request $request)
    {
        $list = $request->user()->events()->lists('id')->toArray();
        $eventId = $request->get("eventId");

        if (!in_array($eventId, $list)) {
            $request->user()->parties()->attach($eventId);
        }

        return response()->json(['status' => 'completed', 'eventId'=>$eventId]);
    }
}
