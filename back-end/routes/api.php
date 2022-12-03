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
4- get_posts_group_joined - user_id / browse joined groups
5- get_post_user_id - user_id / browse account view
6- edit_profile - user_id
7- add_post - group_id, user_id, post_title, post_description, post_URL
8- get_post_group group_id (from the front end we take what we want)/ browse group View
9- get_post_id post_id (from the front end we take what we want) - For getting a single post
10- add_like post_id (1 for add, 0 for remove)
11- add_comment post_id
12- join_group group_id, user_id(1 for add, 0 for remove)
13- delete_post_id  post_id, user_id
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(["prefix" => "test"], function(){
    Route::get("get/{id}", [groupifyController::class, "testGet"]);
    Route::post("insert", [groupifyController::class, "testInsert"]);
    Route::post("update", [groupifyController::class, "testUpdate"]);


});