<?php

namespace App\Http\Controllers;

use App\EventInvitation;
use App\Jobs\EventInvitationEmail;
use Illuminate\Http\Request;

use App\Http\Requests;

class InvitationsController extends Controller
{
    public function sendEventInvitation(Request $request, $eventId, $userId)
    {
        $event = $request->user()->events()->whereId($eventId)->first();
        if($event){
            $invitation = EventInvitation::create([
                'event_id' => $eventId,
                'sender_id' => $request->user()->id,
                'receiver_id' => $userId
            ]);
            $invitationList = $event->invitations;
            $this->dispatch(new EventInvitationEmail($invitation));
            return response()->json(["status"=>"completed","invitationList"=>$invitationList]);
        }
    }

    public function replyEventInvitation($invitationId, $response)
    {
        $invitation = EventInvitation::find($invitationId);
        if($invitation){
            $invitation->update([
                'status'=>$response
            ]);

            $receiver = $invitation->receiver;
            $hasReplied = $receiver->parties()->whereEventId($invitation->event->id)->first();
            if($hasReplied){
                $receiver->parties()->detach($invitation->event->id);
            }
            $receiver->parties()->attach($invitation->event->id,[
                "status"=>$response
            ]);
            return "Thank for your reply!";
        }
        return "Em.... Something wrong.";
    }
}
