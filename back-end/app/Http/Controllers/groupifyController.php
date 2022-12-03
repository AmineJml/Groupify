<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;




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
        //fillRequest($post_id, $user_id, $comment, $value, $request);
        if($comment->save()){
            return response()->json([
                "result" => true 
            ]);
        }     
    }
    
    // public function fillRequest($input1, $input2, $input3, $value, $request){
    //     $value->input1 = $request->input1;
    //     $value->input2 = $request->input2;
    //     $value->input3 = $request->input3;
    // }
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
        return response()->json([
            "result" => "YAY" 
        ]); 
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
 }
