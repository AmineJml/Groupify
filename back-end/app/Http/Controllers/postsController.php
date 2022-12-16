<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Validator;

use Illuminate\Http\Request;

class postsController extends Controller
{
    function get_all_posts(){ //takes nothing return all informations about a post may be displayed to all users (even guests)
        $post = Post::select('group_id', 'user_id', 'post_title', 'post_description', 'post_URL')
                          ->where('is_deleted', '=', 0)
                          ->get();

        return response() -> json([
            "result" => $post
        ]);
    }

    function get_post_group($group_id){ //takes group_id return all informations about a post may be displayed to the group (even guests)
        $post = Post::select('group_id', 'user_id', 'post_title', 'post_description', 'post_URL')
                          ->where('is_deleted', '=', 0)
                          ->where('group_id', '=', $group_id)
                          ->get();
        return response() -> json([
            "result" => $post
        ]);
    }

    function get_post_id($user_id){ //takes user_id return all informations about a post may be displayed to the user only
        $post = Post::select('group_id', 'user_id', 'post_title', 'post_description', 'post_URL')
                          ->where('is_deleted', '=', 0)
                          ->where('user_id', '=', $user_id)
                          ->get();
        return response() -> json([
            "result" => $post
        ]);
    }

    function add_post(Request $request)
    {
        $post = new Post;
        $post->group_id = $request->group_id;
        $post->user_id = $request->user_id;
        $post->post_title = $request->post_title;
        $post->post_description = $request->post_description;
        $post->post_URL = $request->post_URL;

        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'user_id' => 'required',
            'post_title' => 'required',
            'post_description' => 'required',
            'post_URL' => 'required',
        ]);
        //validator infinite loop
        if($validator->fails()) {
            return response()->json([
                "result" => "false" 
            ]); 
        }
        if($post->save()){
            return response()->json([
                "result" => "true" 
            ]);
        } 
    }

    function delete_post(Request $request){
        $post = new Post;
        $post->post_id = $request->post_id;

        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
        ]);
        //validator infinite loop
        if($validator->fails()) {
            return response()->json([
                "result" => "false_auth" 
            ]); 
        }

        $check_post = Post::where('post_id',  $post->post_id)
                    ->where('is_deleted', 0)
                    ->get();


        if($check_post){
            $post = Post::where('post_id',  $post->post_id)
                     ->update(['is_deleted'=> 1]);
            return response()->json([
                "result" => "true" 
            ]);    
        }

        return response()->json([
            "result" => "false" 
        ]);    

    }
}
