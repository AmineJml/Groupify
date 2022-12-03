<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\groupifyController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
apis:
1- login    - Username, password
2- register - fname, lname, username, password
3- get_all_posts 
4- get_post_group_joined - user_id
5- get_post_user_id - user_id
6- edit_profile - user_id
7- add_post - user_id 
8- get_post_group (from the front end we take what we want)
9- get_post_id (from the front end we take what we want)
10- add_like (1 for add, 0 for remove)
11- add_comment
12- join_group (1 for add, 0 for remove)
13- delete_post_id 
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/test", [groupifyController::class, "test"]);

Route::get("/test", [groupifyController::class, "test"]);

Route::group(["prefix" => "products"], function(){
    Route::get("test", [groupifyController::class, "test"]);

});