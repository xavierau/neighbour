<?php

namespace App\Http\Controllers;


use App\FacebookFeed;
use App\FacebookUser;
use App\Http\Requests;
use Carbon\Carbon;
use Facebook\Facebook;
use Illuminate\Support\Facades\DB;

class FacebookFeedsController extends Controller
{
    public function create()
    {
        $fb = new Facebook([
            'app_id'                => env("FACEBOOK_APP_ID"),
            'app_secret'            => env("FACEBOOK_APP_SECRET"),
            'default_graph_version' => 'v2.6',
        ]);
        $token = DB::table("facebook_users")->whereId(env("FACEBOOK_PAGE_ADMIN_ID"))->first()->token;
        $fields = [
            'limit'        => 5,
            'format'       => 'json',
            'access_token' => $token,
            'fields'       => "
            from{id, name, picture}, 
            comments{from{id, name, picture} ,id, type, message, created_time}, 
            message, 
            type,
            created_time"
        ];
        $query = http_build_query($fields);
        $facebookPageId = env("FACEBOOK_PAGE_ID");
        $uri = "$facebookPageId/feed?$query";
        $response = $fb->get($uri);

        $feedEdge = $response->getGraphEdge();

        $this->getFeeds($fb, $feedEdge);

        return redirect('/');
    }

    private function createRecords($item)
    {
        $object = json_decode($item);
        if ($object->type == 'status') {
            $newFbFeed = $this->createFbFeedRecord($object);

            if (isset($object->comments)) {
                foreach ($object->comments as $comment){
                    $this->createFbFeedRecord($comment, $newFbFeed);
                }
            }
        }
    }

    private function fbUserExist($fdUserId):bool
    {
        $user = FacebookUser::whereId($fdUserId)->first();

        return !!$user;
    }

    private function getFeeds($fb, $edge)
    {

        foreach ($edge as $item) {
            $this->createRecords($item);
        }

        $nextBatch = $fb->next($edge);
        if ($nextBatch) {
            $this->getFeeds($fb, $nextBatch);
        }
    }

    /**
     * @param $fbUserEdge
     */
    private function createFbUser($fbUserEdge)
    {
        $data = [
            "id"   => $fbUserEdge->id,
            "name" => $fbUserEdge->name,
        ];

        if (isset($fbUserEdge->email)) {
            $data["email"] = $fbUserEdge->email;
        }
        if (isset($fbUserEdge->picture->url)) {
            $data["avatar"] = $fbUserEdge->picture->url;
        }

        FacebookUser::create($data);
    }

    /**
     * @param                   $fbFeed
     * @param \App\FacebookFeed $replyFeed
     * @return static
     */
    private function createFbFeedRecord($fbFeed, FacebookFeed $replyFeed=null)
    {
        if(! $this->alreadyExist($fbFeed)){

            $data = [
                'message'    => $fbFeed->message,
                "message_id" => $fbFeed->id,
                "reply_to"   => $replyFeed?$replyFeed->id:0,
                "author_id"  => $fbFeed->from->id,
            ];

            if(isset($fbFeed->created_time)){
                if(is_string($fbFeed->created_time)){
                    $data['created_at'] = $this->covertFacebookTimeStamp($fbFeed->created_time);
                }else{
                    $data['created_at'] = $this->covertFacebookTimeStamp($fbFeed->created_time->date);
                }
            }

            $newFeed = FacebookFeed::create($data);

            if(isset($fbFeed->picture)){
                $data = [
                    'link' => $fbFeed->picture,
                    'type' => 'image'
                ];
                $newFeed->media()->media()->create([])->update($data);;
            }

            if(!$this->fbUserExist($fbFeed->from->id)){
                $this->createFbUser($fbFeed->from);
            }

            if(!$replyFeed){
                $this->addToStream($newFeed);
            }

            return $newFeed;
        }
    }

    private function alreadyExist($fbFeed):bool
    {
        $feed = FacebookFeed::whereMessageId($fbFeed->id)->first();

        return !! $feed;
    }

    private function addToStream($newFeed)
    {
        $stream =$newFeed->stream()->create([]);
        $stream->item_id = $newFeed->id;
        $stream->created_at = $newFeed->created_at;
        $stream->save();
    }

    private function covertFacebookTimeStamp($created_time)
    {
        $dateTimeObject = new Carbon($created_time);
        return $dateTimeObject->addHours(8)->toDateTimeString();
    }
}
