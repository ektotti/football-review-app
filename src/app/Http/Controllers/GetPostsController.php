<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\PostService;

class GetPostsController extends Controller
{
    public function __invoke(Request $request, PostService $postService)
    {
        
        if ($request->tag_name) {
            $searchedPost = $postService->getSearchedPosts($request->tag_name);
            return $searchedPost;
        }

        $refererUrl = parse_url($_SERVER['HTTP_REFERER']);
        $refererPath = $refererUrl['path'];
        if (preg_match("/\/user\/\d+/", $refererPath)) {
            $selectedUserPosts = $postService->getUserPagePosts($refererPath);
            return $selectedUserPosts;
        } else {
            $indexPosts = $postService->getIndexPosts();
            return $indexPosts;
        }
    }
}
