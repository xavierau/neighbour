<?php
/**
 * Author: Xavier Au
 * Date: 24/6/2016
 * Time: 12:42 PM
 */


Route::get('dashboard', function () {
    return view('dashboard');
});
//
//Route::get("permissions", "PermissionsController@index");
//Route::get("permissions/create", "PermissionsController@create");
//Route::get("permissions/{permissionId}/edit", "PermissionsController@edit");
//Route::put("permissions/{permissionId}", "PermissionsController@update");
//Route::post("permissions", "PermissionsController@store");
//Route::delete("permissions/{permissionId}", "PermissionsController@delete");

Route::get("settings", "SettingsController@index");
Route::get("settings/create", "SettingsController@create");
Route::get("settings/{settingId}/edit", "SettingsController@edit");
Route::put("settings/{settingId}", "SettingsController@update");
Route::post("settings", "SettingsController@store");
Route::delete("settings/{settingId}", "SettingsController@delete");

Route::resource("categories", "CategoriesController");
//
//Route::get("categories", "CategoriesController@index");
//Route::post("categories", "CategoriesController@store");
//Route::get("categories/new", "CategoriesController@create");
//Route::get("categories/{id}/edit", "CategoriesController@edit");
//Route::put("categories/{id}", "CategoriesController@update");
//Route::delete("categories/{id}/delete", "CategoriesController@delete");


Route::resource("clans", "ClansController");
Route::resource("users", "UsersController");

Route::resource('roles', "RolesController");
Route::resource('permissions', "PermissionsController");