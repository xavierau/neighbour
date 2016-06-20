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

use App\Category;
use App\Event;
use App\Feed;
use App\Setting;
use App\Stream;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

//Route::get("fbFeedConversation", function(){
//
//    // get all fb users, create user if they don't exist
//    $fbUsers = \App\FacebookUser::all();
//    foreach ($fbUsers as $fbUser){
//        if(!$fbUser->email){
//            $fbUser->update(["email"=>$fbUser->id."@dummy.com"]);
//        }
//        $user = User::whereEmail($fbUser->email)->first();
//        if(!$user){
//            $user = User::create([
//                'name'     => $fbUser->name,
//                'email'    => $fbUser->email,
//                'avatar'    => $fbUser->avatar,
//                'password' => bcrypt(env("DUMMY_PASSWORD"))
//            ]);
//            $theFbUser =  \App\FacebookUser::whereEmail($user->email)->first();
//            $theFbUser->update(["user_id"=>$user->id]);
//        }
//    }
    // get top level fb feed and convert to feed and add to stream
//    $topLevelFbFeeds = \App\FacebookFeed::whereReplyTo(0)->get();
//    foreach ($topLevelFbFeeds as $fbFeed){
//        $fbUser = \App\FacebookUser::whereId($fbFeed->author_id)->first();
//        $user = $fbUser->user;
//        $data = [
//            'content'     => $fbFeed->message,
//            'reply_to'    => 0,
//            'category_id' => 1,
//            'created_at' => $fbFeed->created_at
//        ];
//        $feed = $user->feeds()->create($data);
//        $fbFeed->feed_id = $feed->id;
//        $fbFeed->save();
//
//        if (isset($fbFeed->media)) {
//            foreach ($fbFeed->media as $media) {
//                $data = [
//                    'link' => $media->picture,
//                    'type' => $media->type
//                ];
//                $feed->media()->create([])->update($data);
//            }
//        }
//
//        // add to stream
//        $stream = $feed->stream()->create([]);
//        $stream->item_id = $feed->id;
//        $stream->created_at = $feed->created_at;
//        $stream->save();
//
//    }

    // get other level fb feeds and convert to feed
//    $fbFeeds = \App\FacebookFeed::where('reply_to',"<>",0)->get();
//    foreach ($fbFeeds as $fbFeed){
//        $fbUser = \App\FacebookUser::whereId($fbFeed->author_id)->first();
//        $user = $fbUser->user;
//        $data = [
//            'content'     => $fbFeed->message,
//            'reply_to'    => $fbFeed->reply_to,
//            'category_id' => 1,
//            'created_at' => $fbFeed->created_at
//        ];
//        $feed = $user->feeds()->create($data);
//        $fbFeed->feed_id = $feed->id;
//        $fbFeed->save();
//
//        if (isset($fbFeed->media)) {
//            foreach ($fbFeed->media as $media) {
//                $data = [
//                    'link' => $media->picture,
//                    'type' => $media->type
//                ];
//                $feed->media()->create([])->update($data);
//            }
//        }
//    }

    // add feed to stream
//});


Route::get('/', function () {
    if (Auth::guest()) {
        $settings = Cache::remember('settings', 10, function(){
            return Setting::all();
        });

        return view('welcome', compact("settings"));
    }

    return redirect("/app");
});

Route::get("invitation/replay/{invitationId}/{status}",[
    "as"=> "replyInvitation",
    "uses"=>"InvitationsController@replyEventInvitation"]);





//Route::get('/sampling', function () {
//
//    function pushToStream($collection, $stream)
//    {
//        $collection->map(function ($item) use ($stream) {
//            $stream->push($item);
//        });
//
//        return $stream;
//    }
//
//
//
//    $topLevelFeeds = Feed::whereReplyTo(0)->get();
//    $events = Event::all();
//    $temp = new Collection();
//
//    while ($topLevelFeeds->count() != 0 and $events->count() != 0) {
//        $firstFeed = $topLevelFeeds->first();
//        $firstEvent = $events->first();
//        if ($firstFeed->created_at > $firstEvent->created_at) {
//            $temp->push($topLevelFeeds->first());
//            $topLevelFeeds->shift();
//        } else {
//            $temp->push($events->first());
//            $events->shift();
//        }
//    };
//    if ($topLevelFeeds->count() != 0) {
//        $temp = pushToStream($topLevelFeeds, $temp);
//    }
//    if ($events->count() != 0) {
//        $temp = pushToStream($events, $temp);
//    }
//
//    foreach ($temp as $item){
//        $item->stream()->create([]);
//    }
//
//    dd(Stream::orderBy('created_at', 'desc')->with("item")->paginate(5));
//
//});

Route::group(['middleware'=>['auth','hasPermission:one']], function (){
    Route::get('permissionTesting');
});

Route::get("permissions", "PermissionsController@index");
Route::get("permissions/create", "PermissionsController@create");
Route::get("permissions/{permissionId}/edit", "PermissionsController@edit");
Route::put("permissions/{permissionId}", "PermissionsController@update");
Route::post("permissions", "PermissionsController@store");
Route::delete("permissions/{permissionId}", "PermissionsController@delete");

Route::get("settings", "SettingsController@index");
Route::get("settings/create", "SettingsController@create");
Route::get("settings/{settingId}/edit", "SettingsController@edit");
Route::put("settings/{settingId}", "SettingsController@update");
Route::post("settings", "SettingsController@store");
Route::delete("settings/{settingId}", "SettingsController@delete");


Route::group(['middleware' => 'auth'], function () {


    Route::get('/app', function () {
        $settings = Cache::remember('settings', 10, function(){
           return Setting::all();
        });

        return view('app', compact("settings"));
    });
    Route::get('/app/events/{events?}', function () {
        $settings = Cache::rememberForever('settings', function(){
            return Setting::all();
        });

        return view('app', compact("settings"));
    });


    Route::group(['middleware' => "isAdmin", "prefix"=>"admin"], function () {
        Route::get('dashboard', function () {
            return view('dashboard');
        });
        Route::get("categories", "CategoriesController@index");
        Route::post("categories", "CategoriesController@store");
        Route::get("categories/new", "CategoriesController@create");
        Route::get("categories/{id}/edit", "CategoriesController@edit");
        Route::put("categories/{id}", "CategoriesController@update");
        Route::delete("categories/{id}/delete", "CategoriesController@delete");

        Route::resource('roles', "RolesController");
        Route::resource('clans', "ClansController");

        
        
        
        
    });

    Route::group(["prefix" => "api"], function () {
        Route::get('metrics', function () {
            $metrics = [
                [
                    "label" => "Visit Per Date"
                ],
                [
                    "label" => "Number of Post Per Day"
                ]
            ];
            $shownMetrics = [
                [
                    "label" => "Visit Per Date",
                    "data"  => null
                ],
                [
                    "label" => "Number of Post Per Day",
                    "data"  => Feed::where("created_at", "<", date("Y-m-d h:i:sa"))->count()
                ]
            ];

            return response()->json(compact("metrics", "shownMetrics"));
        });

        Route::get('marquee', function(){
//            $events = Event::where("startDateTime", ">", new DateTime())->get();
//
//            $categories = Cache::remember('categories', 10, function(){
//                return Category::all();
//            });
//            $hotDealCategory =  $categories->first(function($index, $category){
//                return $category->code == "hotDeals";
//            });
//            $feeds = Feed::whereCategoryId($hotDealCategory->id)
//                ->orderBy("created_at", "desc")
//                ->get();
//
//            $collection = $events->merge($feeds);
//
//            return response()->json(compact("collection"));
        });

        Route::get("search", "SearchController@search");

        Route::get('like/{object}/{objectId}', "LikesController@like");
        Route::get('unlike/{object}/{likeId}', "LikesController@unlike");


        Route::get("profile", "UsersController@getProfile");
        Route::post("profile", "UsersController@updateProfile");
        Route::get("feed/{id}", "FeedsController@getFeed");
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

        Route::get("invitation/event/{eventId}/user/{userId}", "InvitationsController@sendEventInvitation");

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
            $content = "";
            $promise = $client->sendAsync($httpRequest)->then(function ($response) use ($content) {
                $stream = $response->getBody();
                while (!$stream->eof()) {
                    $content = $content . $stream->read(1024);
                }

                if (preg_match('/(?:<head[^>]*>)(.*)<\/head>/isU', $content, $matches)) {
                    $content = $matches[1];
                }

                return getMetaTags($content);
            });

            return $promise->wait();

        });
    });
    Route::get("/app/{segment1?}/{segment2?}/{segment3?}", function(){
        $settings = Cache::rememberForever('settings', function(){
            return Setting::all();
        });
        return view("app", compact('settings'));
    });
});
Route::group(['prefix'=>'facebook'], function(){
    Route::get("register", "Auth\\AuthController@facebookSignUp");
    Route::get("login", "Auth\\AuthController@facebookLogin");
    Route::get("register/callback", "Auth\\AuthController@handleFacebookSignUpCallback");
    Route::get("/", "FacebookFeedsController@create");

});


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

    if (preg_match_all($pattern, $str, $out)) {
        return array_combine($out[1], $out[2]);
    }

    return array();
}