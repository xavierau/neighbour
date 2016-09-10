<?php
/**
 * Author: Xavier Au
 * Date: 24/6/2016
 * Time: 12:42 PM
 */


Route::get('dashboard', function () {
    return view('dashboard');
});

Route::get("settings", "SettingsController@index");
Route::get("settings/create", "SettingsController@create");
Route::get("settings/{settingId}/edit", "SettingsController@edit");
Route::put("settings/{settingId}", "SettingsController@update");
Route::post("settings", "SettingsController@store");
Route::delete("settings/{settingId}", "SettingsController@delete");

Route::resource("categories", "CategoriesController");


Route::resource("clans", "ClansController");
Route::resource("users", "UsersController");

Route::resource('roles', "RolesController");
Route::resource('feeds', "FeedsController");
Route::resource('permissions', "PermissionsController");

Route::get('media', 'MediaController@index');
Route::delete('media/{id}/delete', 'MediaController@destroy');