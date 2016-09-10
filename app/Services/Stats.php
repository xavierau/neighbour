<?php
/**
 * Author: Xavier Au
 * Date: 24/6/2016
 * Time: 1:16 PM
 */

namespace App\Services;


use App\Enums\ContentType;
use App\Enums\Frequency;
use App\Feed;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Stats
{

    public function get($code, int $type, string $frequency, Carbon $fromDate = null, Carbon $toDate = null):array {
        $data = [];
        switch ($code){
            case 'noppd':
                $data = $this->numberOfPostBetween($type, $frequency, $fromDate, $toDate);
                break;
        }
        return $data;
    }


    public function numberOfUsers():int
    {
        return User::count();
    }

    public function numberOfPostBetween(int $type, string $frequency, Carbon $fromDate = null, Carbon $toDate = null):array
    {
        if ($type == ContentType::POST and $frequency == Frequency::DAILY) {

            // initialized date
            $toDate = $toDate ?? Carbon::now();
            $fromDate = $fromDate ?? Carbon::now()->addDays(-7);

            // get user number post per day
            $result = $this->fetchRawDataCollection($type, $fromDate, $toDate);

            // manipulate result array as needed
            $collection = new Collection($result);
            $collection = $this->collectionGroupByDate($collection);

            $stats = $this->constructFinalStatArray($frequency, $fromDate, $toDate, $collection);

            return $stats;
        }
        abort(405, 'invalid query');
    }

    //Number of users posting a post, a comment or an event per day and per week;
    public function  numberOfUserWhoPostBetween(int $type, string $frequency, Carbon $fromDate = null, Carbon $toDate = null):array
    {
        if ($frequency == Frequency::DAILY) {
            $toDate = $toDate ?? Carbon::now();
            $fromDate = $fromDate ?? Carbon::now()->addDays(-7);

            $result = $this->fetchRawDataCollection($type, $fromDate, $toDate);
            $collection = new Collection($result);
            $result = $this->collectionGroupByDate($collection, $frequency);
            foreach ($result as $date => $collection){
                $result[$date] = $this->collectionGroupByUserId($collection);
            }
            $stats = $this->constructFinalStatArray($frequency, $fromDate, $toDate, $result);
            return $stats;
        }
    }

    public function mostCommentPost(int $top = 5)
    {
        $conditions = [
          ['reply_to',"<>", 0]
        ];
        // get all the commented post (which reply to <> 0)
        $result = DB::table("feeds")
                ->where($conditions)
                ->select('reply_to')
                ->get();

        $collection = new Collection($result);
        $collection = $collection->groupBy(function($feed){
            return $feed->reply_to;
        });

        $collection = $collection->map(function(Collection $col){
            return $col->count();
        });

        $temp = $collection->sortBy(function($key){
            return -$key;
        });
        $inter = $temp->slice(0,$top);

        $result = [];

        foreach ($inter as $feedId => $numberOfComments){
            $feed = Feed::find($feedId);
            $result[] = [
                "feed"=>$feed
            ];
        }

        return $result;
    }

    private function collectionGroupByUserId(Collection $collection)
    {
        return $collection->groupBy(function ($item) {
            return $item->user_id;
        });
    }

    private function collectionGroupByDate(Collection $collection, string $dateFormat = 'Y-m-d')
    {
        return $collection->groupBy(function ($item) use ($dateFormat) {
            return Carbon::parse($item->created_at)->format($dateFormat);
        });
    }

    private function fetchDataBetween(string $table, array $conditions,Carbon $fromDate, Carbon $toDate):array
    {
        $result = DB::table($table)->where($conditions)
            ->select("user_id", "created_at", "reply_to")
            ->get();
        return $result;
    }

    private function fetchEventBetween(Carbon $fromDate, Carbon $toDate)
    {
        $conditions = [
            ["created_at", ">", $fromDate->format("Y-m-d")],
            ["created_at", "<=", $toDate->format("Y-m-d")]
        ];
        return $this->fetchDataBetween("events", $conditions, $fromDate, $toDate);
    }

    private function fetchPostData($fromDate, $toDate)
    {
        $conditions = [
            ["reply_to", 0],
            ["created_at", ">", $fromDate->format("Y-m-d")],
            ["created_at", "<=", $toDate->format("Y-m-d")]
        ];
        return $this->fetchDataBetween("feeds", $conditions, $fromDate, $toDate);
    }
    private function fetchCommentData($fromDate, $toDate)
    {
        $conditions = [
            ["reply_to", "<>", 0],
            ["created_at", ">", $fromDate->format("Y-m-d")],
            ["created_at", "<=", $toDate->format("Y-m-d")]
        ];
        return $this->fetchDataBetween("feeds", $conditions, $fromDate, $toDate);
    }

    /**
     * @param int            $type
     * @param \Carbon\Carbon $fromDate
     * @param \Carbon\Carbon $toDate
     */
    private function fetchRawDataCollection(int $type, Carbon $fromDate, Carbon $toDate)
    {
        switch ($type) {
            case(ContentType::EVENT):
                $result = $this->fetchEventBetween($fromDate, $toDate);
                break;
            case(ContentType::POST):
                $result = $this->fetchPostData($fromDate, $toDate);
                break;
            case(ContentType::COMMENT):
                $result = $this->fetchCommentData($fromDate, $toDate);
                break;
            default:
                $result = new Collection();
        }
        return $result;
    }

    /**
     * @param string         $frequency
     * @param \Carbon\Carbon $fromDate
     * @param \Carbon\Carbon $toDate
     * @param                $collection
     * @return mixed
     */
    private function constructFinalStatArray(string $frequency, Carbon $fromDate, Carbon $toDate, $collection)
    {
        $stats = [];
        while ($toDate->gt($fromDate)) {
            $stats[$fromDate->format($frequency)] = $collection->has($fromDate->format($frequency)) ? $collection[$fromDate->format($frequency)]->count() : 0;
            $fromDate->addDay();
        }

        return $stats;
    }
}