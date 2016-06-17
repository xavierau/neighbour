<?php

namespace App\Http\Controllers;


use App\Events\RequireNewFacebookFeeds;
use App\Http\Requests;

class FacebookFeedsController extends Controller
{
    public function create()
    {
        event(new RequireNewFacebookFeeds());
        return redirect('/');
    }
}
