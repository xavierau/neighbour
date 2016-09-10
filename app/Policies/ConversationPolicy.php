<?php

namespace App\Policies;

use App\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Conversation::class);
    }
}
