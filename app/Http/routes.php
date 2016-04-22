<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>'auth'], function(){
    Route::get('/app', function () {
        return view('app');
    });



    Route::group(["prefix"=>"api"], function(){
       Route::get("profile", "UsersController@getProfile");
       Route::post("profile", "UsersController@updateProfile");
       Route::post("feed", "FeedsController@postFeed");
       Route::get("feeds/{feedOption}", "FeedsController@getFeeds");
       Route::get("frontPage", "FrontPageController@index");
       Route::get("categoryList", "CategoriesController@getCategoryList");
    });
});

Route::get("facebook/register","Auth\\AuthController@facebookSignUp");
Route::get("facebook/login","Auth\\AuthController@facebookLogin");
Route::get("facebook/register/callback","Auth\\AuthController@handleFacebookSignUpCallback");
Route::get("facebookTesting", function(){
   $fbService = new \App\Services\FbServices("CAACEdEose0cBAPZClc7jb0Va9aja6mUZB461cSZCfwZBDbxEBmwmF597tvubHuZAHNlXAFjIOeZAryZC9k4c0NmctSKnS6dTwg98uysMS2bmnvjIOFlWXZBLKkqfaCCuBVfWPj7DJnNhd86kfkI3aKecsUNskrf9NRjvBmtPjdDIXwfgFCPriPacOtrmBCec6MakNdgLLfdyHOMKOXyxlonE");

    $response = $fbService->get("/445732152292769/feed");
    dd($response);
});



Route::auth();

Route::get('/home', 'HomeController@index');
