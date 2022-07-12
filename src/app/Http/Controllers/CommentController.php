<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests\CommentStoreRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentStoreRequest $request)
    {
        $loginUser = Auth::user();
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->post_user_id = $request->postUserId;
        $comment->comment_user_id = $loginUser->id;
        $comment->post_id = $request->postId;

        $comment->save();

    }
}
