<?php

namespace App\Http\Controllers;

use App\Enums\ContentType;
use App\Enums\Frequency;
use App\Services\Stats;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class StatsController extends Controller
{
    private $availableMetrics = [
        [
            "code"=>"nouppd",
            "label"=> "Number of Users Post Per Day",
        ],
        [
            "code"=>"noppd",
            "label"=> "Number of Post Per Day"
        ]
    ];

    public function main(Request $request)
    {
        if($metricCode = $request->get('metric') and in_array($metricCode, array_map(function($metric){
                return $metric['code'];
            } , $this->availableMetrics))){
            $type = $request->get('type') ?? "COMMENT";
            $frequency = $request->get('frequency') ?? "DAILY";
            $fromDate = $request->has("from")? Carbon::parse($request->get("from")) : Carbon::now()->addDays(-7);
            $toDate = $request->has("to")? Carbon::parse($request->get("from")) : Carbon::now();
            $service = new Stats();
//            $data = $service->numberOfPostBetween(constant(ContentType::class."::$type"), constant(Frequency::class."::$frequency"), $fromDate, $toDate);
//            $data = $service->numberOfUserWhoPostBetween(constant(ContentType::class."::$type"), constant(Frequency::class."::$frequency"), $fromDate, $toDate);
            $data = $service->mostCommentPost();
            return response()->json(compact('data'));
        }else{
            return response()->json(["metrics"=>$this->availableMetrics]);
        }
    }
}
