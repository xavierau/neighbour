<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
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
    public function getAllMessage($conversationId)
    {
        $messages = $this->messageService->getConversationMessages($conversationId);

        return response()->json(compact('messages'));

    }

}
