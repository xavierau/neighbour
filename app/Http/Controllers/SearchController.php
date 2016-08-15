<?php

namespace App\Http\Controllers;

use App\Feed;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $result = null;
        if ($queryTerm = $request->get('query')) {
            $requestUser = $request->user();
            $result = DB::table("users")
                ->whereClanId($requestUser->clan_id)
                ->join('feeds', 'feeds.id','=', "users.id")
                ->select("users.first_name","users.last_name","users.avatar","feeds.*")
                ->where(function($query) use ($queryTerm) {
                    $query->where("content", "like", "%$queryTerm%")
                        ->orWhere("first_name", "like", "%$queryTerm%")
                        ->orWhere("last_name", "like", "%$queryTerm%");
                })->paginate(15);


//            $result = Feed::with('sender')
//                ->whereReplyTo(0)
//                ->orderBy("created_at", "desc")
//                ->join('users', "users.id", "=", "feeds.user_id")
//                ->select("users.first_name","users.last_name","users.avatar","feeds.*")
//                ->where(function ($query) use ($queryTerm) {
//                    $query->where("content", "like", "%$queryTerm%")
//                        ->orWhere("first_name", "like", "%$queryTerm%")
//                        ->orWhere("last_name", "like", "%$queryTerm%");
//                })
//
//                ->paginate(15);
        }
        return response()->json($result);
    }
}
