<?php

namespace App\Policies;

use App\Event;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Event::class);
    }

    public function get(User $user) {
        return !! $user;
    }

    public function getParticularEvent(User $user, $event) {
        return $user->clan_id == $event->organiser->clan_id;
    }
    public function join(User $user, $event) {
        return $user->clan_id == $event->organiser->clan_id;
    }

    public function create(User $user) {
        return !! $user;
    }

    public function update(User $user, $event) {
        return $user->id == $event->user_id;
    }

    public function delete(User $user, $event) {
        return $user->id == $event->user_id;
    }
}
