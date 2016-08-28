<?php

use App\Event;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends TestCase
{
    public function test_get_others_events_query() {
        $user = User::first();
        $event = new Event();
        $scopeEvents = $event->getOthersPublicEvents($user->id)->get();
        $events = $event->where('user_id','<>', $user->id)->get();

        $this->assertEquals($scopeEvents->count(), $events->count());

        for ($i=0; $i< $scopeEvents->count(); $i++){
            $this->assertEquals($scopeEvents[$i], $events[$i]);
        }

    }
}
