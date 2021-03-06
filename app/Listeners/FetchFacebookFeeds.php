<?php
/**
 * Author: Xavier Au
 * Date: 18/6/2016
 * Time: 2:01 AM
 */

namespace App\Listeners;


use App\FacebookFeed;
use App\FacebookUser;
use App\Feed;
use App\Http\Controllers\FacebookFeedsController;
use App\User;
use Carbon\Carbon;
use Facebook\Facebook;
use Illuminate\Support\Facades\DB;

class FetchFacebookFeeds
{

    private $token;
    private $fb;
    private $pageFeedQueryFields;

    /**
     * FetchFacebookFeeds constructor.
     */
    public function __construct()
    {
    }

    public function handle()
    {
        $this->fb = new Facebook([
            'app_id'                => env("FACEBOOK_APP_ID"),
            'app_secret'            => env("FACEBOOK_APP_SECRET"),
            'default_graph_version' => 'v2.6',
        ]);

        $this->getFacebookPageAdminUserToken();

        $this->getPageFeedFields();

        $this->fetchFacebookServerAndCreateFeeds();

    }

    private function getFacebookPageAdminUserToken()
    {
        $this->token = DB::table("facebook_users")->whereId(env("FACEBOOK_PAGE_ADMIN_ID"))->first()->token;
    }

    private function getPageFeedFields()
    {
        $this->pageFeedQueryFields = [
            'limit'        => 5,
            'format'       => 'json',
            'access_token' => $this->token,
            'fields'       => "
            from{id, name, picture}, 
            comments{from{id, name, picture} ,id, type, message, created_time}, 
            message, 
            type,
            created_time"
        ];

    }

    private function fetchFacebookServerAndCreateFeeds()
    {
        $feedEdge = $this->getFeedEdge();

        $this->getFeeds($feedEdge);
    }

    private function getFeeds($edge)
    {

        foreach ($edge as $item) {
            $this->createRecords($item);
        }

        $nextBatch = $this->fb->next($edge);
        if ($nextBatch) {
            $this->getFeeds($nextBatch);
        }
    }

    private function createRecords($item)
    {
        $object = json_decode($item);
        if ($object->type == 'status') {
            $newFbFeed = $this->findOrCreateFacebookFeed($object);

            if (isset($object->comments)) {
                foreach ($object->comments as $comment) {
                    $this->findOrCreateFacebookFeed($comment, $newFbFeed);
                }
            }
        }
    }

    private function findOrCreateFacebookFeed($fbFeed, FacebookFeed $replyFeed = null):FacebookFeed
    {
        if (!$this->alreadyExist($fbFeed)) {

            $data = $this->prepareFacebookFeedDataForInsert($fbFeed, $replyFeed);

            $newFbFeed = FacebookFeed::create($data);

            if (isset($fbFeed->picture)) {
                $data = [
                    'link' => $fbFeed->picture,
                    'type' => 'image'
                ];
                $newFbFeed->media()->media()->create([])->update($data);;
            }

            $user = $this->getUser($fbFeed);

            $newFeed = $this->createNewFeed($user, $newFbFeed, $replyFeed);

            if (!$replyFeed) {
                $this->addToStream($newFeed);
            }

            return $newFbFeed;
        }else{
            $feed = FacebookFeed::whereMessageId($fbFeed->id)->first();
            return $feed;
        }
    }

    private function alreadyExist($fbFeed):bool
    {
        $feed = FacebookFeed::whereMessageId($fbFeed->id)->first();

        return !!$feed;
    }

    private function covertFacebookTimeStamp($created_time)
    {
        $dateTimeObject = new Carbon($created_time);

        return $dateTimeObject->addHours(8)->toDateTimeString();
    }

    private function getUser($fbFeed):User
    {
        $fbUser = $this->fbUserExist($fbFeed->from->id);

        if ($fbUser) {
            $user = User::whereEmail($fbUser->email)->first();
        } else {
            $fbUser = $this->createFbUser($fbFeed->from);
            $user = User::create([
                'name'     => $fbUser->name,
                'email'    => $fbUser->email,
                'avatar'   => $fbUser->avatar,
                'password' => bcrypt(env("DUMMY_PASSWORD"))
            ]);
            $theFbUser = FacebookUser::whereEmail($user->email)->first();
            $theFbUser->update(["user_id" => $user->id]);
        }

        return $user;
    }

    private function fbUserExist($fdUserId)
    {
        $user = FacebookUser::whereId($fdUserId)->first();

        return $user;
    }

    private function createFbUser($fbUserEdge): FacebookUser
    {
        $data = [
            "id"   => $fbUserEdge->id,
            "name" => $fbUserEdge->name,
        ];

        $data["email"] = isset($fbUserEdge->email) ? $fbUserEdge->email : $fbUserEdge->id . "@dummy.com";

        if (isset($fbUserEdge->picture->url)) {
            $data["avatar"] = $fbUserEdge->picture->url;
        }

        return FacebookUser::create($data);
    }

    private function createNewFeed(User $user, FacebookFeed $newFbFeed, FacebookFeed $replyToFeed = null):Feed
    {

        $replyTo = $replyToFeed ? $replyToFeed->feed->id : 0;
        $data = [
            'content'     => $newFbFeed->message,
            'reply_to'    => $replyTo,
            'category_id' => 1,
            'created_at' => $newFbFeed->created_at
        ];
        $feed = $user->feeds()->create($data);

        $newFbFeed->feed_id = $feed->id;
        $newFbFeed->save();

        if (isset($newFbFeed->media)) {
            foreach ($newFbFeed->media as $media) {
                $data = [
                    'link' => $media->picture,
                    'type' => $media->type
                ];
                $feed->media()->create([])->update($data);
            }
        }

        return $feed;
    }

    private function addToStream($newFeed)
    {
        $stream = $newFeed->stream()->create([]);
        $stream->item_id = $newFeed->id;
        $stream->created_at = $newFeed->created_at;
        $stream->save();
    }

    /**
     * @return mixed
     */
    private function getFeedEdge()
    {
        $query = http_build_query($this->pageFeedQueryFields);
        $facebookPageId = env("FACEBOOK_PAGE_ID");
        $uri = "$facebookPageId/feed?$query";
        $response = $this->fb->get($uri);

        $feedEdge = $response->getGraphEdge();

        return $feedEdge;
    }

    /**
     * @param                   $fbFeed
     * @param \App\FacebookFeed $replyFeed
     * @return array
     */
    private function prepareFacebookFeedDataForInsert($fbFeed, FacebookFeed $replyFeed)
    {
        $data = [
            'message'    => $fbFeed->message??"",
            "message_id" => $fbFeed->id,
            "reply_to"   => $replyFeed ? $replyFeed->id : 0,
            "author_id"  => $fbFeed->from->id,
        ];

        if (isset($fbFeed->created_time)) {
            $data['created_at'] = is_string($fbFeed->created_time) ?
                $this->covertFacebookTimeStamp($fbFeed->created_time) :
                $this->covertFacebookTimeStamp($fbFeed->created_time->date);
        }

        return $data;
    }
}