<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class likesController extends Controller
{
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
}
