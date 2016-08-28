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
        $myEvents = $request->user()->events()->defaultQuery()->get();
        $publicEvents = Event::getOthersPublicEvents($request->user()->id)->get();
        

        return response()->json(["myEvents" => $myEvents, 'publicEvents' => $publicEvents]);
    }

    public function getEvent($eventId)
    {
        $event = Event::find($eventId);
        $event->load("participants", "media");

        return response()->json(['event' => $event, 'numberOfParticipants' => $event->numberOfParticipants()]);
    }

    public function postEvent(Request $request)
    {
        $data = $this->prepareDateForEventCreation($request);

        $event = $request->user()->events()->create($data);
        $event->participants()->attach($request->user()->id, ['status'=>'yes']);

        $this->createMediaIfNeeded($request, $event);

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

    public function updateEvent(Request $request , $eventId)
    {
        $data = $this->prepareDateForEventCreation($request);
        $event = Event::findOrFail($eventId);
        $event->update($data);
        $this->createMediaIfNeeded($request, $event);

        $event->load(["organiser", "media"]);

        return response()->json(compact("event"));
    }

    public function deleteEvent(Request $request, $id)
    {
        $event = $request->user()->events()->whereId($id)->first();
        if($event)
            $event->stream->first()->delete();
            $event->delete();
        return response("Ok");
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
        $startHour = $data['startHour'];
        $startMin = $data['startMin'];
        if ($startHour) {
            $startHour = str_pad($startHour, 2, "0", STR_PAD_LEFT);
            if ($startMin) {
                $startMin = str_pad($startMin, 2, "0", STR_PAD_LEFT);
                $time = ($startHour . ":" . $startMin.":00");
            } else {
                $time = ($startHour . ":00:00");
            }
        } else {
            $time = "00:00:00";
        }
        $data["startDateTime"] = $data['startDate'] . " " . $time;




        if(!empty($data['endDate'])){
            $endHour = $data['endHour'];
            $endMin = $data['endMin'];

            if ($endHour) {
                $endHour = str_pad($endHour, 2, "0", STR_PAD_LEFT);
                if ($endMin) {
                    $endMin = str_pad($endMin, 2, "0", STR_PAD_LEFT);

                    $time = ($endHour . ":" . $endMin.":00");
                } else {
                    $time = ($endHour . ":00:00");
                }
            } else {
                $time = "00:00:00";
            }
            $data["endDateTime"] = $data['endDate'] . " " . $time;
        }


        return $data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $event
     */
    private function createMediaIfNeeded(Request $request, $event)
    {
        $files = array_filter($request->all(), function ($entry) {
            return $entry instanceof UploadedFile;
        });

        if (!empty($files)) {
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
    }
}
