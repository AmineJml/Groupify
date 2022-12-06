<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

/*
apis:
1- login - completed in auth
2- register - completed in auth
13- logout - completed in auth
--------------get-------------------
3- get_all_posts
4- get_post_group_joined
5- get_post_user_id ; delete_post_id
8- get_post_group
9- get_post_id
------------------------------------
---------------update---------------
6- edit_profile
10- add_like (1 for add, 0 for remove)
12- join_group (1 for add, 0 for remove)

---------------insert---------------
7- add_post
11- add_comment
*/ 


class groupifyController extends Controller
{
    //###########################_GET_##############################
    function testGet($id){
        $comment = Comment::select('comment')
                          ->where('comment_id', '=', $id)
                          ->get();
        return response() -> json([
            "result" => $comment
        ]);
    }
    //###########################_INSERT_##############################
    function testInsert(Request $request){
        $comment = new Comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = $request->user_id;
        $comment->comment = $request->comment;

        if($comment->save()){
            return response()->json([
                "result" => true 
            ]);
        }     
    }
    //###########################_UPDATE_##############################
    function testUpdate(Request $request)
    {
        $comment = new Comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = $request->user_id;
        $comment->comment = $request->comment;

        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
        ]);
        //validator infinite loop
        if($validator->fails()) {
            return response()->json([
                "result" => "false" 
            ]); 
        }

        $comment = Comment::where('post_id', 1)
                          ->where('user_id', 1)
                          ->update(['comment'=> "TESTING UPDATE", 'user_id' => 2]);
        return response()->json([
            "result" => "YAY" 
        ]);    
    }
    /*
    ======================================================================================
                                GET - APIS
    ======================================================================================  
    */ 
    function getAllPosts(){ //takes nothing return all informations about a post may be displayed to all users (even guests)
        $post = Post::select('group_id', 'user_id', 'post_title', 'post_description', 'post_URL')
                          ->where('is_deleted', '=', 0)
                          ->get();
        return response() -> json([
            "result" => $post
        ]);
    }

    function get_post_group_joined($user_id){ //takes user_id return all posts for user joined groups
        //create an array that holds all groups ids
        //then select the posts with these specific grpupid
        $groups = Group::select

        $post = Comment::select('group_id', 'user_id', 'post_title', 'post_description', 'post_URL')
                          ->where('is_deleted', '=', 0)
                          ->get();
        return response() -> json([
            "result" => $post
        ]);
    }
 }
