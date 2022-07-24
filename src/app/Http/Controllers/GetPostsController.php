<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GetPostsController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = [];
        if ($request->tag_name) {
            Log::debug('tagページ');
            $postsQuelyBuilder = Post::getByTagName($request->tag_name);
            $paginatePosts = $postsQuelyBuilder->simplePaginate(3);
            $posts = $paginatePosts->toArray();
            $posts += array("hasMorePage" => $paginatePosts->hasMorePages());
            return $posts;
        }

        $refererUrl = parse_url($_SERVER['HTTP_REFERER']);
        $refererPath = $refererUrl['path'];
        if (preg_match("/\/user\/\d+/", $refererPath)) {
            Log::debug('ユーザーページ');
            $userId = str_replace("/user/", "", $refererPath);
            $postsQuelyBuilder = Post::getByUserId($userId);
            $paginatePosts = $postsQuelyBuilder->simplePaginate(3);
            $posts = $paginatePosts->toArray();
            $posts += array("hasMorePage" => $paginatePosts->hasMorePages());
            return $posts;
        } else {
            Log::debug('インデックスページ');
            $postsQuelyBuilder = Auth::check() ? Post::getFollowingPost(Auth::id()) : Post::getAllIndexPost();
            $paginatePosts = $postsQuelyBuilder->simplePaginate(3);
            $posts = $paginatePosts->toArray();
            $posts += array("hasMorePage" => $paginatePosts->hasMorePages());
            return $posts;
        }
    }
}
