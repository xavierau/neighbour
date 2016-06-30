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
        $myEvents = Event::whereUserId($request->user()->id)
            ->with(['media', "invitations"])->orderBy('created_at', 'desc')->get();
        $publicEvents = Event::where('isPublic', 1)
            ->where('user_id', "<>", $request->user()->id)
            ->with('media')
            ->orderBy('created_at', 'desc')
            ->get();
        

        return response()->json(["myEvents" => $myEvents, 'publicEvents' => $publicEvents]);
    }

    public function getEvent($eventId)
    {
        $event = Event::find($eventId);

        return response()->json(['event' => $event, 'numberOfParticipants' => $event->numberOfParticipants()]);
    }

    public function postEvent(Request $request)
    {
        $data = $this->prepareDateForEventCreation($request);

//        dd($data);

        $event = $request->user()->events()->create($data);

        $files = array_filter($request->all(), function ($entry) {
            return $entry instanceof UploadedFile;
        });

        if ( empty($files) ) {
            $mediaService = new MediaServices();
            foreach ($files as $file) {
                $link = $mediaService->storeFeedPhoto($file);
                $data = [
                    'link' => $link,
                    'type' => 'image'
                ];
                $event->media()->create([])->update($data);
            }
        }
        event(new NewEventCreated($event));
        $event->load(["organiser", "media"]);

        return response()->json(compact("event"));
    }

    public function joinEvent(Request $request)
    {
        $event = Event::findOrFail($request->get("eventId"));
        if($request->has('option')){
            if($request->get('option') == "maybe"){
                $event = $this->joinEventWIthOption($request,$event, "maybe");
            }elseif($request->get('option') == "no"){
                $event = $this->joinEventWIthOption($request,$event, "no");
            }
        }else{
            $event = $this->joinEventWIthOption($request,$event, "yes");
        }
        return response()->json(['status' => 'completed', 'eventId' => $event->id]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Event               $event
     * @param string                   $option
     * @return \Illuminate\Http\JsonResponse
     */
    private function joinEventWIthOption(Request $request, Event $event, string $option)
    {
        $eventParticipant = $event->participants()->whereUserId($request->user()->id)->first();
        if ($eventParticipant) {
            if ($eventParticipant->pivot->status !=$option) {
                $eventParticipant->pivot->update(['status' =>$option]);
            }
        } else {
            $event->participants()->attach($request->user()->id, ["status" =>$option]);
        }

       return $event;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function prepareDateForEventCreation(Request $request)
    {
        $data = $request->all();
        if ($data['startHour']) {
            if ($data['startMin']) {
                $time = ($data['startHour'] . ":" . $data['startMin'].":00");
            } else {
                $time = ($data['startHour'] . ":00:00");
            }
        } else {
            $time = "00:00:00";
        }
        $data["startDateTime"] = $data['startDate'] . " " . $time;

        if(!empty($data['endDate'])){
            if ($data['endHour']) {
                if ($data['endMin']) {
                    $time = ($data['endHour'] . ":" . $data['endMin'].":00");
                } else {
                    $time = ($data['endHour'] . ":00:00");
                }
            } else {
                $time = "00:00:00";
            }
            $data["endDateTime"] = $data['endDate'] . " " . $time;
        }


        return $data;
    }
}
