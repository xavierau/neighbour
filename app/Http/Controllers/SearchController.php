<?php

namespace App\Http\Controllers;

use App\Feed;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if($queryTerm = $request->get('query')){
            $result = Feed::join('users', "users.id", "=", "feeds.user_id")
                ->join("categories", "categories.id", "=", "feeds.category_id")
                ->select("feeds.*", "users.first_name", "users.last_name", "categories.name")
                ->whereClanId($request->user()->clan_id)
                ->where('feeds.reply_to', '=', 0)
                ->where('users.first_name', "like", "%$queryTerm%")
                ->orWhere('users.last_name', "like", "%$queryTerm%")
                ->orWhere("feeds.content", "like", "%$queryTerm%")
                ->orWhere("categories.name", "like", "%$queryTerm%")
                ->with(['sender'=>function($query){
                    return $query->select("first_name", "last_name", "id", "avatar");
                }, 'category'=>function($query){
                    $query->select("name", "id");
                }, 'likes'=> function ($query)use($request) {
                    $query->where('user_id', $request->user()->id);
                }, "media"])
                ->paginate(15);
            return response()->json($result);
        }
    }
}
