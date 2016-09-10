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
            "code"=>"noppd",
            "label"=> "Number of Post Per Day",
            "type"=> "POST"
        ]

    ];

    public function main(Request $request)
    {
        if($metricCode = $request->get('metric') and in_array($metricCode, array_map(function($metric){
                return $metric['code'];
            } , $this->availableMetrics))){
            $type = $request->get('type') ?? "POST";
            $frequency = $request->get('frequency') ?? "DAILY";
            $fromDate = $request->has("from")? Carbon::parse($request->get("from")) : Carbon::now()->addDays(-7);
            $toDate = $request->has("to")? Carbon::parse($request->get("from")) : Carbon::now();
            $service = new Stats();
            $data = $service->get($request->get('metric'), constant(ContentType::class."::$type"), constant(Frequency::class."::$frequency"), $fromDate, $toDate);
            return response()->json(compact('data'));
        }else{
            return response()->json(["metrics"=>$this->availableMetrics]);
        }
    }
}
