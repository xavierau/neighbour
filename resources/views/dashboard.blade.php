@extends('layouts.app')

@section('content')
    <div class="container" id="dashboard-app">
        <div class="col-sm-6">
            <graph-metric></graph-metric>
        </div>
    </div>
@endsection
@section('script')
    <script id="graphMetricTemplate" type="x-template">
        <div class="panel panel-default" id="@{{randomId}}">
            <div class="panel-heading">
                <div class="form-group">
                    <label>Choose Metric:</label>
                    <select class="form-control" v-model="metric" @@change="updateMetric">
                    <option v-for="metric in availableMetrics" :value="metric">@{{metric.label}}</option>
                    </select>
                </div>

            </div>
            <div class="panel-body"></div>
        </div>
    </script>
    <script src="{{asset("js/dashboard.js")}}"></script>
@endsection