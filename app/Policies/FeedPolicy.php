<?php

namespace App\Policies;

use App\Feed;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedPolicy extends BasicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Feed::class);
    }

    public function post(User $user) {
        return !! $user;
    }

    public function getTheFeed(User $user, $feed) {
        return $user->clan_id == $feed->sender->clan_id;
    }
    public function get(User $user) {
        return !! $user;
    }

    public function comment(User $user, $feed) {
        return $user->clan_id == $feed->sender->clan_id;
    }

    public function getComments(User $user, $feed) {
        return $user->clan_id == $feed->sender->clan_id;
    }

    public function delete(User $user, $feed) {
        return $user->id == $feed->sender->id;
    }

    public function deleteComment(User $user, $feed) {
        return $user->id == $feed->sender->id;
    }
}
