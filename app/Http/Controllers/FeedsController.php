<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
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
            if ($feed->category->showInPublic) {
                $feed->load("sender");

                return response()->json(['status' => "okay", 'feed' => $feed]);
            }

            return response()->json(['status' => "okay"]);
        }
    }

    public function getFeeds(Request $request, $feedOption)
    {
        if ($feedOption == "showPublic") {
            $feeds = Feed::publicShown()
                ->standardFetchSetting()
                ->get();
            $events = Event::where('isPublic', 1)->orderBy('created_at', 'desc')->with('organiser')->take(5)->get();

            $stream = new Collection();
            while($feeds->count() != 0 and $events->count()!=0){
                $firstFeed = $feeds->first();
                $firstEvent = $events->first();
                if($firstFeed->created_at > $firstEvent->created_at){
                    $stream->push($feeds->first());
                    $feeds->shift();
                }else{
                    $stream->push($events->first());
                    $events->shift();
                }
            };
            if($feeds->count() != 0) $stream =$this->pushToStream($feeds, $stream);
            if($events->count() != 0) $stream =$this->pushToStream($events, $stream);

            return response()->json($stream);
        } elseif (in_array($feedOption, Category::lists('code')->toArray())) {
            $feeds = Feed::feedCategory($feedOption)
                ->standardFetchSetting()
                ->get();

            return response()->json($feeds);
        }
    }

    private function pushToStream($collection, $stream)
    {
        $collection->map(function($item)use($stream){
            $stream->push($item);
        });
           return $stream;
    }
}
