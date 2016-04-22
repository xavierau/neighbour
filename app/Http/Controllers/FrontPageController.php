<?php

namespace App\Http\Controllers;

use App\Category;
use App\Feed;
use Illuminate\Http\Request;

use App\Http\Requests;

class FrontPageController extends Controller
{
    public function index(Request $request)
    {
        $list = Category::select("id", "name")->get();
        $feeds = Feed::orderBy('created_at')
            ->whereHas("category", function($q){
                $q->where("showInPublic", true);
            })
            ->with("sender")
            ->take(15)
            ->get();
        return response()->json(["feeds"=>$feeds, "categoryList"=>$list]);
    }
}
