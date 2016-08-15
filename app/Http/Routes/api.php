<?php
/**
 * Author: Xavier Au
 * Date: 24/6/2016
 * Time: 11:21 AM
 */

use App\Events\UserApprovedEvent;
use App\Feed;
use App\Jobs\ShareFeedByEmail;
use App\User;
use App\View;

Route::group(['middleware' =>"isAdmin", "prefix" =>"metrics"], function(){
    require_once "metrics.php";
});


Route::get('marquee', "MarqueesController@get");

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
Route::get("feed/{feedId}/whoLikes", function($feedId){
    $feed = Feed::find($feedId);
    $likes = $feed->likes()->with("user")->get();

    return response()->json($likes);
});
Route::post("feeds/{feedId}/views", function(\Illuminate\Http\Request $request, $feedId){
    $feed = Feed::find($feedId);
    $user = $request->user();
    $data = [
        "user_id" => $user->id,
        "feed_id" => $feed->id,
    ];
    $view = View::whereUserId($user->id)->whereFeedId($feed->id)->first();
    if(!$view){
        View::create($data);
    }


    $likes = "okay";

    return response()->json($likes);
});
Route::get("feeds/{feedId}/whoViews", "FeedsController@whoViews");

Route::post('events', "EventsController@postEvent");
Route::get('events', "EventsController@getEvents");
Route::get('events/{eventId}', "EventsController@getEvent");
Route::put('events/{eventId}', "EventsController@updateEvent");
Route::delete('events/{eventId}', "EventsController@deleteEvent");
Route::post('joinEvent', "EventsController@joinEvent");
// This is when user click the button in the app
Route::get("invitation/event/{eventId}/user/{userId}", "InvitationsController@sendEventInvitation");

Route::get('conversations', 'ConversationsController@getAllConversations');
Route::get('conversation', 'ConversationsController@getConversation');
Route::get('conversations/new/{userId}', 'ConversationsController@createANewConversation');
Route::post('conversations/messages', 'ConversationsController@newMessage');
Route::get('conversations/messages/{conversationId}', 'ConversationsController@getAllMessage');


Route::get('notifications', "NotificationsController@getNotifications");
Route::get('notifications/acknowledge', "NotificationsController@acknowledge");

Route::get("users/search/username", "UsersController@searchByUserName");

Route::get('urlPreview', "UrlsController@preview");

Route::post("share/{feedType}/{feedId}/", function(\Illuminate\Http\Request $request, $feedType, $feedId){
    dispatch(new ShareFeedByEmail($request->get('email'), $request->user(), $feedType, $feedId));
    dd($request->get('email'));
});


Route::get('users/pending', "UsersController@getPendingUsers");
Route::put('users/approve/{userId}', function(\Illuminate\Http\Request $request, $userId){
    $approver = $request->user();
    if($approver && $approver->can("approveUser")){
        $newStatus = \App\UserStatus::whereCode("new")->first();

        if($approver->is('dev') or $approver->is("sadmin")){
            $user = User::find($userId);
        }else{
            $user = User::whereClanId($request->user()->clan->id)->whereId($userId)->first();
        }
        if ($user){
            $user->email_confirmation_token = str_random(128);
            $user->status()->associate($newStatus);
            $user->save();
            event(new UserApprovedEvent($user));
            return response()->json(['Status'=>"approved"]);
        }
        return response()->json(['Status'=>"NA"]);
    }
});