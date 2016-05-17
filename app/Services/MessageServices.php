<?php
/**
 * Author: Xavier Au
 * Date: 26/4/2016
 * Time: 9:48 AM
 */

namespace App\Services;


use App\Conversation;
use App\Events\NewMessageEvent;
use App\Events\Notification;
use App\Events\NotificationEvent;
use App\Message;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use InvalidArgumentException;

/**
 * Class MessageServices
 * @package app\Services
 */
class MessageServices
{
    /**
     * @type Conversation
     */
    public $conversation;
    /**
     * @type \Illuminate\Http\Request
     */
    protected $request;
    /**
     * @type \App\Message
     */
    protected $message;

    /**
     * MessageServices constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Message message
     */
    public function create()
    {
        // get the conversation
        $this->getConversation();
        // create a new message for the conversation
        $this->message = $this->addMessageToConversation();
        
        return $this->message;
    }

    public function getAllRecipients($conversationId)
    {
        return Conversation::find($conversationId)->users;
    }

    /**
     * @param null $conversationId
     * @return Collection Messages
     */
    public function getConversationMessages($conversationId)
    {
        if (in_array($conversationId, $this->request->user()->conversations()->lists('id')->toArray())){
            $this->getConversation($conversationId);
            return Message::orderBy('created_at', 'desc')->whereConversationId($conversationId)->get();
        }
        throw new InvalidArgumentException("conversationId must present and in user conversation list");
    }

    public function getAllConversationForAUser()
    {
        return $this->request->user()->conversations()->with([
            'users'=>function($query){
                $query->where('user_id', '<>', $this->request->user()->id);
            }
        ])->get();
    }

    /**
     * @param null $conversationId
     */
    public function getConversation($conversationId = null)
    {
        $id = $conversationId ? $conversationId : $this->request->get('conversationId');
        if ($id) {
            $this->conversation = Conversation::findOrFail($id);
        } else {
            if ($this->request->has('receiverId')) {
                $receiver = User::find($this->request->get('receiverId'));
                $conversation = $this->request->user()
                    ->conversations
                    ->intersect($receiver->conversations)
                    ->first();
                if (!$conversation) {
                    $conversation = Conversation::create([]);
                    $this->request->user()->conversations()->attach($conversation->id);
                    $receiver->conversations()->attach($conversation->id);
                }
                $this->conversation = $conversation;
            }
        }
        return $this->conversation;
    }

    /**
     * @return Message
     */
    private function addMessageToConversation()
    {
        return $this->request->user()->messages()->create([
            'message'         => $this->request->get('message'),
            'conversation_id' => $this->conversation->id
        ]);
    }

    public function notifyOtherUsers()
    {
        $users = $this->conversation->users->filter(function($user){
            return $user->id != $this->request->user()->id;
        });

        foreach ($users as $user){
            event(new NotificationEvent($this->message, $user->id, $this->request->user()->id));
            event(new Notification($user));
        }
    }


}