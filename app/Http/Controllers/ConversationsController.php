<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Events\Notification;
use App\Events\NotificationEvent;
use App\Http\Requests;
use App\Services\MessageServices;
use Illuminate\Http\Request;


/**
 * Class ConversationsController
 * @package App\Http\Controllers
 */
class ConversationsController extends Controller
{
    private $messageService;

    /**
     * ConversationsController constructor.
     * @param $messageServices
     */
    public function __construct(Request $request)
    {
        $this->messageService = new MessageServices($request);
    }


    public function getAllConversations()
    {
        $conversations = $this->messageService->getAllConversationForAUser();
        return response()->json(compact('conversations'));
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function newMessage()
    {
        $message = $this->messageService->create();
        event(new NewMessageEvent($message));
        $this->messageService->notifyOtherUsers();
        return response()->json(compact('message'));

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getConversation()
    {
        $conversation = $this->messageService->getConversation();

        return response()->json(compact('conversation'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $conversationId
     * @return mixed
     */
    public function getAllMessage(Request $request, $conversationId)
    {
        $messages = $this->messageService->getConversationMessages($conversationId);
        $users = $this->messageService->getAllRecipients($conversationId);
        $recipient = $users->filter(function($user)use($request){
                return $user->id != $request->user()->id;
            })->first();

        return response()->json(compact('messages', 'recipient'));

    }

}
