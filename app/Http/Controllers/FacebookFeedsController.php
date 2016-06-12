<?php

namespace App\Http\Controllers;


use App\FacebookFeed;
use App\User;
use Facebook\Facebook;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class FacebookFeedsController extends Controller
{
    public function create()
    {
        $fb = new Facebook([
            'app_id' => env("FACEBOOK_APP_ID"),
            'app_secret' => env("FACEBOOK_APP_SECRET"),
            'default_graph_version' => 'v2.6',
        ]);
        $token = DB::table("facebook_users")->first()->token;
        $fields = [
          'limit'=>5,
            'format'=>'json',
            'access_token'=>$token,
            'fields'=>"from, comments, message, type"
        ];
        $query = http_build_query($fields);
        $facebookPageId = env("FACEBOOK_PAGE_ID");
        $uri = "$facebookPageId/feed?$query";
        $response = $fb->get($uri);

        $feedEdge = $response->getGraphEdge();

        $this->getFeeds($fb, $feedEdge);
        return redirect('/');
    }

    private function createRecords($item){
        $object = json_decode($item);
        if(isset($object->message)) {
            $newFeed = FacebookFeed::create([
                'message'=>$object->message,
                "message_id"=>$object->id,
                "reply_to"=>0,
                "author_id"=>$object->from->id
            ]);

            if(isset($object->comments)) {
                array_map(function($comment)use($newFeed){
                    FacebookFeed::create([
                        'message'=>$comment->message,
                        "message_id"=>$comment->id,
                        "reply_to"=>$newFeed->id,
                        "author_id"=>$comment->from->id
                    ]);
                }, $object->comments);

            }

        }

    }

    private function getFeeds($fb, $edge)
    {
        
        foreach ($edge as $item) {
            logger($item);
            $this->createRecords($item);
        }
        $nextBatch = null;
        $nextBatch = $fb->next($edge);
        if ($nextBatch) {
            $this->getFeeds($fb, $nextBatch);
        }
    }
}
