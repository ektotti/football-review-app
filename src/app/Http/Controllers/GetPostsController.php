<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use Illuminate\Http\Request;
use App\Service\PostService;

class GetPostsController extends Controller
{
    public function __invoke(Request $request, PostService $postService)
    {

        if ($request->tag_name) {
            return new PostCollection($postService->getSearchedPosts($request->tag_name));
        }

        $indexPosts = $postService->getIndexPosts();
        return new PostCollection($indexPosts);
        
        $refererUrl = parse_url($_SERVER['HTTP_REFERER']);
        $refererPath = $refererUrl['path'];
        if (preg_match("/\/user\/\d+/", $refererPath)) {
            return new PostCollection($postService->getUserPagePosts($refererPath));
        } else {
            return new PostCollection($postService->getIndexPosts());
        }
    }
}
