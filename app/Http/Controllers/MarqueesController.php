<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use App\Feed;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;

class MarqueesController extends Controller
{
    public function get()
    {
        $events = $this->getUpcomingEvents();

        $hotDeals = $this->getHotDeals();

         $collection = $events->merge($hotDeals);

            return response()->json(compact("collection"));
    }

    /**
     * @return mixed
     */
    private function getUpcomingEvents()
    {
        $events = Event::where("startDateTime", ">", new DateTime())->get();

        return $events;
    }

    /**
     * @return mixed
     */
    private function getHotDeals()
    {
        $categories = Cache::remember('categories', 10, function () {
            return Category::all();
        });
        $hotDealCategory = $categories->first(function ($index, $category) {
            return $category->code == "hotDeals";
        });
        $feeds = Feed::whereCategoryId($hotDealCategory->id)
            ->orderBy("created_at", "desc")
            ->get();

        return $feeds;
    }
}
