<?php
/**
 * Author: Xavier Au
 * Date: 24/6/2016
 * Time: 12:38 PM
 */

Route::group(['prefix'=>'facebook'], function() {
    Route::get("register", "Auth\\AuthController@facebookSignUp");
    Route::get("login", "Auth\\AuthController@facebookLogin");
    Route::get("register/callback", "Auth\\AuthController@handleFacebookSignUpCallback");
    Route::get("/", "FacebookFeedsController@create");
});
Route::group(['prefix'=>'google'], function() {
    Route::get("register", "Auth\\AuthController@googleSignUp");
    Route::get("login", "Auth\\AuthController@googleLogin");
    Route::get("register/callback", "Auth\\AuthController@handleGoogleSignUpCallback");
});
Route::group(['prefix'=>'twitter'], function() {
    Route::get("register", "Auth\\AuthController@twitterSignUp");
    Route::get("login", "Auth\\AuthController@twitterLogin");
    Route::get("register/callback", "Auth\\AuthController@handleTwitterSignUpCallback");
});