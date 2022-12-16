<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class commentsController extends Controller
{
    function add_comment(Request $request){
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

        if($comment->save()){
            return response()->json([
                "result" => "true" 
            ]);
        }    
    }
}
