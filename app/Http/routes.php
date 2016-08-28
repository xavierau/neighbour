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

use App\City;
use App\Clan;
use App\Feed;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('statTest', "StatsController@getUserContentStats");
Route::get('email/confirmation', "UsersController@confirmEmail");

Route::get('/', function () {
    if (Auth::guest()) {
        $settings = Cache::rememberForever('settings', function () {
            return Setting::all();
        });
        $buildings = Clan::get();
        $cities = City::select("id", "label")->get();
        return view('welcome', compact("settings","buildings", "cities"));
    }
    return redirect("/app");
});

// This is when user click the button in email
Route::get("invitation/replay/{invitationId}/{status}", [
    "as"   => "replyInvitation",
    "uses" => "InvitationsController@replyEventInvitation"
]);

Route::group(['middleware' => 'auth'], function () {

    Route::post('commenting', function (\Illuminate\Http\Request $request) {

        if (!empty($request->get('comment'))) {
            $comment = $request->get('comment');
            $user = $request->user();
            Mail::send('emails.comment', compact('user', 'comment'), function ($m) use ($user) {
                $m->from('comment@neighbour.dev', $user->name);

                $m->to(env("MAIL_COMMENT"), "ADMINISTRATOR")->subject('USER COMMENT');
            });
        }


        return response()->json(['data' => $request->get('comment')]);
    });

    Route::get("/app/{segment1?}/{segment2?}/{segment3?}", function () {
        $settings = Cache::rememberForever('settings', function () {
            return Setting::all();
        });

        return view("app", compact('settings'));
    });


    Route::group(['middleware' => "isAdmin", "prefix" => "admin"], function () {
        require_once app_path('Http/Routes/adminPages.php');
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
        require_once __DIR__ . "/Routes/api.php";
    });
});

require_once __DIR__ . "/Routes/socialLogin.php";

Route::auth();