<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use app\Services\MessageServices;
use Illuminate\Http\Request;


/**
 * Class ConversationsController
 * @package App\Http\Controllers
 */
class ConversationsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function newMessage(Request $request)
    {
        $messageService = new MessageServices($request);
        $message = $messageService->create();

        return response()->json(compact('message'));

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getConversation(Request $request)
    {
        $messageService = new MessageServices($request);
        $conversation = $messageService->conversation;

        return response()->json(compact('conversation'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $conversationId
     * @return mixed
     */
    public function getAllMessage(Request $request, $conversationId)
    {
        $messageService = new MessageServices($request);
        $messages = $messageService->getConversationMessages($conversationId);

        return response()->json(compact('messages'));

    }

}
