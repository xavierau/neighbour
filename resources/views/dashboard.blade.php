@extends('layouts.app')

@section('content')
    <router-view></router-view>
@endsection
@section('script')
    <script src="{{asset("js/dashboard.js")}}"></script>
@endsection