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

    function get_post_group($group_id){ //takes nothing return all informations about a post may be displayed to all users (even guests)
        $post = Post::select('group_id', 'user_id', 'post_title', 'post_description', 'post_URL')
                          ->where('is_deleted', '=', 0)
                          ->where('group_id', '=', $group_id)
                          ->get();
        return response() -> json([
            "result" => $post
        ]);
    }

    function get_post_id($user_id){ //takes nothing return all informations about a post may be displayed to all users (even guests)
        $post = Post::select('group_id', 'user_id', 'post_title', 'post_description', 'post_URL')
                          ->where('is_deleted', '=', 0)
                          ->where('user_id', '=', $user_id)
                          ->get();
        return response() -> json([
            "result" => $post
        ]);
    }
}
