<?php

namespace App\Http\Controllers;

use App\Category;
use App\Feed;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class FeedsController extends Controller
{
    public function postFeed(Request $request){
        if($request->ajax()){
            $feedData = $request->all();
            $feedData["reply_to"]=0;
            $feed = Auth::user()->feeds()->create($feedData);
            if($feed->category->showInPublic){
                $feed->load("sender");
                return response()->json(['status'=>"okay", 'feed'=>$feed]);
            }
            return response()->json(['status'=>"okay"]);
        }
    }

    public function getFeeds(Request $request, $feedOption)
    {
        if($feedOption=="showPublic"){
            $feeds = Feed::publicShown()
                ->standardFetchSetting()
                ->get();
            return response()->json($feeds);
        }
        elseif(in_array($feedOption, Category::lists('code')->toArray())){
            $feeds = Feed::feedCategory($feedOption)
                ->standardFetchSetting()
                ->get();
            return response()->json($feeds);
        }
    }
}
