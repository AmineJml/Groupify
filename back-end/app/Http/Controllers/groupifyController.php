<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\UserJoinedGroup;



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

        $comment = Comment::where(['post_id', 1], ['user_id', 1])
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
        $array = Group::select('group_id')
                        ->where(['user_id', '=', $user_id], ['is_joined', '=', 1] )
                        ->get();

        while($group = $groups->fetch_assoc()){
            $arr_groups[] = $group; //array of the groups by the user
        }
        return response() -> json([
            "result" => $arr_groups
        ]);
                        
        if($blocks){ //if list is not empty
           // (previously blocked user - so we dont set duplicated)
           //- set_visibility to 1
           $response[] = $blocks;
           echo json_encode($response);
        
        }
        return response() -> json([
            "result" => $groups
        ]);
        $post = Comment::select('group_id', 'user_id', 'post_title', 'post_description', 'post_URL')
                          ->where('is_deleted', '=', 0)
                          ->get();
        return response() -> json([
            "result" => $post
        ]);
    }
        /*
    ======================================================================================
                                INSERT/UPDATE - APIS
    ======================================================================================  
    ---------------update---------------
    exceluding register
    6- edit_profile //will come back for later - check with dr. daaoud
    10- add_like (1 for add, 0 for remove) 
    12- join_group (1 for add, 0 for remove)
    13- delete_post_id
    ---------------insert---------------
    7- add_post 0 variables - Completed with testing
    11- add_comment 0 variables - Completed with testing
    */

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
    
    function add_comment(Request $request)
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

        $comment = Comment::where(['post_id', 1], ['user_id', 1])
                          ->update(['comment'=> "TESTING UPDATE", 'user_id' => 2]);
        return response()->json([
            "result" => "YAY" 
        ]);    
    }

    function edit_profile(Request $request)
    {
        $user = new User;
        $user->id = $request->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        //validator infinite loop
        if($validator->fails()) {
            return response()->json([
                "result" => "false" 
            ]); 
        }

        $user = User::where(['email', $user->email])
                          ->update(['name'=> $user->name, 'password' => $request->password]);
        return response()->json([
            "result" => "true" 
        ]);    
    }

    function like_post(Request $request){
        $like = new Like;
        $like->post_id = $request->post_id;
        $like->user_id = $request->user_id;
        $like->is_liked = $request->is_liked;

        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'user_id' => 'required',
            'is_liked' => 'required',
        ]);
        //validator infinite loop
        if($validator->fails()) {
            return response()->json([
                "result" => "false" 
            ]); 
        }

        $check_like = Like::where('post_id',  $like->post_id)
                    ->where('user_id', $like->user_id)
                    ->get();
        if($check_like){
            $like = Like::where('post_id',  $like->post_id)
            ->where('user_id', $like->user_id)
            ->update(['is_liked'=> $like->is_liked]);
            return response()->json([
                "result" => "like_is_found" 
            ]);    
        }
        if($like->save()){
            return response()->json([
                "result" => "true" 
            ]);
        } 
    }

    function join_group(Request $request){

        $UserJoinGroup = new UserJoinedGroup;
        $UserJoinGroup->group_id = $request->group_id;
        $UserJoinGroup->user_id = $request->user_id;
        $UserJoinGroup->is_joined = $request->is_joined;

        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'user_id' => 'required',
            'is_joined' => 'required',
        ]);
        //validator infinite loop
        if($validator->fails()) {
            return response()->json([
                "result" => "false_auth" 
            ]); 
        }

        $check_UserJoinGroup = UserJoinedGroup::where('group_id',  $UserJoinGroup->group_id)
                                            ->where('user_id',  $UserJoinGroup->user_id)
                                            ->get();
        if(!$check_UserJoinGroup){
            $UserJoinGroup = UserJoinedGroup::where('group_id',  $UserJoinGroup->group_id)
                                          ->where('user_id',  $UserJoinGroup->user_id)
                                          ->update(['is_joined'=>  $UserJoinGroup->is_joined]);
            return response()->json([
                "result" => "false" 
            ]);    
        }
        if($UserJoinGroup->save()){
            return response()->json([
                "result" => "true" 
            ]);
        } 
    }

 }
