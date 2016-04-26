<?php
/**
 * Author: Xavier Au
 * Date: 26/4/2016
 * Time: 9:48 AM
 */

namespace app\Services;


use App\Conversation;
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
     * MessageServices constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Message
     */
    public function create()
    {
        // get the conversation
        $this->getConversation();

        // create a new message for the conversation
        return $this->addMessageToConversation();
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

    /**
     * @return void
     */
    private function getConversation($conversationId = null)
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


}