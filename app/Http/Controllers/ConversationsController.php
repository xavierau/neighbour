<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Http\Requests;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ConversationsController extends Controller
{
    public function getAllConversations(Request $request)
    {
        $conversations = $request->user()->conversations()->with(['users'=>function($query)use($request){
            $query->where('user_id','<>', $request->user()->id);
        }])->get();
        return response()->json(compact('conversations'));
    }

    public function createANewConversation(Request $request, $userId)
    {
        if ($request->user()->id != intval($userId)) {
            $receiver = User::find($userId);
            $conversation = Conversation::create([]);

            $request->user()->conversations()->attach($conversation->id);
            $receiver->conversations()->attach($conversation->id);
        }

        return response()->json(compact('conversation'));
    }

    public function newMessage(Request $request)
    {
        if($request->has('conversationId')){
            $conversation = Conversation::find($request->get('conversationId'));
            $message = $request->user()->messages()->create([
                'message'=>$request->get('message'),
                'conversation_id'=>$conversation->id
            ]);
        }else{
            $receiver = User::find($request->get('receiverId'));
            $conversation = $request->user()
                ->conversations
                ->intersect($receiver->conversations)
                ->first();

            if (!$conversation) {
                $conversation = Conversation::create([]);
                $request->user()->conversations()->attach($conversation->id);
                $receiver->conversations()->attach($conversation->id);
            }
            $message = $request->user()->messages()->create([
                'message'         => $request->get("message"),
                'conversation_id' => $conversation->id,
            ]);
        }

        

            return response()->json(compact('message'));

    }

    public function getConversation(Request $request)
    {
        $receiver = User::find($request->get('receiverId'));
        $conversation = $request->user()
            ->conversations
            ->intersect($receiver->conversations)
            ->first();
        if (!$conversation) {
            $conversation = Conversation::create([]);
            $request->user()->conversations()->attach($conversation->id);
            $receiver->conversations()->attach($conversation->id);
        }
        return response()->json(compact('conversation'));
    }

    public function getAllMessage(Request $request, $conversationId)
    {
        if (in_array($conversationId, $request->user()->conversations()->lists('id')->toArray())) {
            $messages = Message::orderBy('created_at', 'desc')->whereConversationId($conversationId)->get();
            return response()->json(compact('messages'));
        }

    }

}
