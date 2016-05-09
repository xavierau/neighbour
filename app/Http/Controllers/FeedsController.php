<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use App\Events\NewPostCreated;
use App\Events\Notification;
use App\Events\NotificationEvent;
use App\Feed;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FeedsController extends Controller
{
    public function postFeed(Request $request)
    {
        if ($request->ajax()) {
            $feedData = $request->all();
            $feedData["reply_to"] = 0;
            $feed = Auth::user()->feeds()->create($feedData);
            
            event(new NewPostCreated($feed));

            if ($feed->category->showInPublic) {
                $feed->load("sender");
                return response()->json(['status' => "okay", 'feed' => $feed]);
            }

            return response()->json(['status' => "okay"]);
        }
    }

    public function getFeeds(Request $request, $feedOption)
    {
        if ($feedOption == "showPublicfrontPage" or $feedOption == 'public') {
            $feeds = Feed::publicShown()
                ->standardFetchSetting()
                ->get();
            $events = Event::where('isPublic', 1)->orderBy('created_at', 'desc')->with('organiser')->take(5)->get();

            $stream = new Collection();
            while ($feeds->count() != 0 and $events->count() != 0) {
                $firstFeed = $feeds->first();
                $firstEvent = $events->first();
                if ($firstFeed->created_at > $firstEvent->created_at) {
                    $stream->push($feeds->first());
                    $feeds->shift();
                } else {
                    $stream->push($events->first());
                    $events->shift();
                }
            };
            if ($feeds->count() != 0) {
                $stream = $this->pushToStream($feeds, $stream);
            }
            if ($events->count() != 0) {
                $stream = $this->pushToStream($events, $stream);
            }

            return response()->json($stream);
        } elseif (in_array($feedOption, $categoryList = Category::lists('code', "id")->toArray())) {
            $feeds = Feed::feedCategory($feedOption)
                ->standardFetchSetting()
                ->get();
            $category_id=0;
            foreach ($categoryList as $id=>$categoryCode){
                if($feedOption == $categoryCode)
                    $category_id=$id;
            }

            return response()->json(compact("feeds", "category_id"));
        }
    }

    public function commentFeed(Request $request)
    {
        $feedId = $request->get('feedId');
        $comment = $request->get('comment');
        $feed = Feed::find($feedId);
        $replay = $request->user()->feeds()->create([
            "content"     => $comment,
            "reply_to"    => $feedId,
            "category_id" => $feed->category->id
        ]);
        $replay->load('sender');
        if($feed->sender->id != $request->user()->id){
            event(new NotificationEvent($feed,$feed->sender->id, $request->user()->id));
            event(new Notification($feed->sender));
        }

        return response()->json(['comment' => $replay]);
    }

    public function getFeedComments(Request $request)
    {
        $comments = Feed::orderBy('created_at', 'desc')
            ->where("reply_to", $request->get('feedId'))
            ->with('sender')
            ->get();

        return response()->json(compact("comments"));
    }

    private function pushToStream($collection, $stream)
    {
        $collection->map(function ($item) use ($stream) {
            $stream->push($item);
        });

        return $stream;
    }

    public function deleteFeed(Request $request, $feedId)
    {
        $feed = $request->user()->feeds()->find($feedId);
        $feed->delete();
        return response()->json('completed');
    }

    public function deleteComment(Request $request, $postId, $commentId)
    {
        $feed = $request->user()->feeds()->whereReplyTo($postId)->whereId($commentId)->first();
        if($feed) $feed->delete();
        return response()->json('completed');
    }
}
