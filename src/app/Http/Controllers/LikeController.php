<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request){
        $loginUser = Auth::user();
        $userId = $loginUser->id;

        $postId = $request->postId;

        $like = new Like;
        $like->user_id = $userId;
        $like->post_id = $postId;
        $like->save();
        return back();
    }

    public function remove(Request $request) {
        $loginUser = Auth::user();
        $userId = $loginUser->id;

        $postId = $request->postId;
        $like = Like::where('post_id', $postId)->where('user_id', $userId)->first();
        $like->delete();
        return back();
    }
}
