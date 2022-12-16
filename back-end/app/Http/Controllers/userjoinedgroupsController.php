<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userjoinedgroupsController extends Controller
{
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
