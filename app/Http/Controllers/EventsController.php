<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class EventsController extends Controller
{
    public function getEvents()
    {
        $events = Events::all();
        return response()->json(["events"=>$events]);
    }

    public function postEvent(Request $request)
    {
        $event = $request->user()->events()->create($request->all());
        return response()->json(["event"=>$event]);
    }
}
