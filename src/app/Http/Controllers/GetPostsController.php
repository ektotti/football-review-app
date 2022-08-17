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
        
        if ($request->tag_name) {
            $searchedPost = $this->showSearchedPosts($request->tag_name);
            return $searchedPost;
        }

        $refererUrl = parse_url($_SERVER['HTTP_REFERER']);
        $refererPath = $refererUrl['path'];
        if (preg_match("/\/user\/\d+/", $refererPath)) {
            $selectedUserPosts = $this->showUserPagePosts($refererPath);
            return $selectedUserPosts;
        } else {
            $indexPosts = $this->showIndexPosts();
            return $indexPosts;
        }
    }

    private function showSearchedPosts($tagName)
    {
        $posts = [];
        $postsQuelyBuilder = Post::getByTagName($tagName);
        if (!($postsQuelyBuilder)) {
            Log::debug('投稿が無いよ。');
            return ["errorMessage"=>"投稿が存在しません"];
        }
        $paginatePosts = $postsQuelyBuilder->simplePaginate(3);
        $posts = $paginatePosts->toArray();
        $posts += array("hasMorePage" => $paginatePosts->hasMorePages());
        return $posts;
    }

    private function showUserPagePosts($refererPath)
    {
        $posts = [];
        Log::debug('ゆーざーページ');
        $userId = str_replace("/user/", "", $refererPath);
        $postsQuelyBuilder = Post::getByUserId($userId);
        $paginatePosts = $postsQuelyBuilder->simplePaginate(3);
        $posts = $paginatePosts->toArray();
        $posts += array("hasMorePage" => $paginatePosts->hasMorePages());
        return $posts;
    }

    private function showIndexPosts()
    {
        $posts = [];
        Log::debug('インデックスーページ');
        $postsQuelyBuilder = Auth::check() ? Post::getFollowingPost(Auth::id()) : Post::getAllIndexPost();
        $paginatePosts = $postsQuelyBuilder->simplePaginate(3);
        $posts = $paginatePosts->toArray();
        $posts += array("hasMorePage" => $paginatePosts->hasMorePages());
        return $posts;
    }
}
