<?php

namespace App\Http\Controllers;

use App\Feed;
use App\Http\Requests;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $result = null;
        if ($queryTerm = $request->get('query')) {
            $result = Feed::with('sender')
                ->whereReplyTo(0)
                ->orderBy("created_at", "desc")
                ->join('users', "users.id", "=", "feeds.user_id")
                ->select("users.name","users.avatar","feeds.*")
                ->where(function ($query) use ($queryTerm) {
                    $query->where("content", "like", "%$queryTerm%")
                        ->orWhere("name", "like", "%$queryTerm%");
                })

                ->paginate(15);
        }
        return response()->json($result);
    }
}
