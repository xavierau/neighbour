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

use App\Events\SocketTesting;
use App\Jobs\EmailNotification;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

Route::get('/', function () {
    if(Auth::guest()){
        return view('welcome');
    }
    return redirect("/app");
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/app', function () {
        return view('app');
    });
    Route::get('/app/events/{events?}', function () {
        return view('app');
    });
    
    
    Route::group(['middleware'=>"isAdmin"], function(){
       Route::get("categories", "CategoriesController@index") ;
       Route::post("categories", "CategoriesController@store") ;
       Route::get("categories/new", "CategoriesController@create") ;
       Route::get("categories/{id}/edit", "CategoriesController@edit") ;
       Route::put("categories/{id}", "CategoriesController@update") ;
       Route::delete("categories/{id}/delete", "CategoriesController@delete") ;
    });

    Route::group(["prefix" => "api"], function () {
        Route::get("profile", "UsersController@getProfile");
        Route::post("profile", "UsersController@updateProfile");
        Route::post("feed", "FeedsController@postFeed");
        Route::delete("feed/{id}", "FeedsController@deleteFeed");
        Route::delete("feeds/{id}/comments/{commentId}", "FeedsController@deleteComment");

        Route::get("frontPage", "FrontPageController@index");
        Route::get("categoryList", "CategoriesController@getCategoryList");
        Route::get("selectCategoryList", "CategoriesController@getSelectCategoryList");
        Route::post("categoryList", "CategoriesController@getCategoryList");

        Route::get('feeds/comments', "FeedsController@getFeedComments");
        Route::post('feeds/comment', "FeedsController@commentFeed");
        Route::get("feeds/{feedOption}", "FeedsController@getFeeds");

        Route::post('events', "EventsController@postEvent");
        Route::get('events', "EventsController@getEvents");
        Route::get('events/{eventId}', "EventsController@getEvent");
        Route::post('joinEvent', "EventsController@joinEvent");
        
        
        Route::get('conversations', 'ConversationsController@getAllConversations');
        Route::get('conversation', 'ConversationsController@getConversation');
        Route::get('conversations/new/{userId}', 'ConversationsController@createANewConversation');
        Route::post('conversations/messages', 'ConversationsController@newMessage');
        Route::get('conversations/messages/{conversationId}', 'ConversationsController@getAllMessage');


        Route::get('notifications', "NotificationsController@getNotifications");
        Route::get('notifications/acknowledge', "NotificationsController@acknowledge");

        Route::get("users/search/username", "UsersController@searchByUserName");

        Route::get('urlPreview', function (\Illuminate\Http\Request $request) {
            $uri = $request->get('uri');
            $client = new Client();
            $httpRequest = new Request('GET', $uri);
            $content="";
            $promise = $client->sendAsync($httpRequest)->then(function($response)use($content){
                $stream = $response->getBody();
                while (!$stream->eof()) {
                    $content = $content. $stream->read(1024);
                }

                if (preg_match('/(?:<head[^>]*>)(.*)<\/head>/isU', $content, $matches)) {
                    $content = $matches[1];
                }
                return getMetaTags($content);
            });

            return $promise->wait();



        });
    });
});

Route::get("facebook/register", "Auth\\AuthController@facebookSignUp");
Route::get("facebook/login", "Auth\\AuthController@facebookLogin");
Route::get("facebook/register/callback", "Auth\\AuthController@handleFacebookSignUpCallback");

Route::auth();

Route::get('/home', 'HomeController@index');

function getMetaTags($str)
{
    $pattern = '
  ~<\s*meta\s

  # using lookahead to capture type to $1
    (?=[^>]*?
    \b(?:name|property|http-equiv)\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  )

  # capture content to $2
  [^>]*?\bcontent\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  [^>]*>

  ~ix';

    if(preg_match_all($pattern, $str, $out))
        return array_combine($out[1], $out[2]);
    return array();
}
