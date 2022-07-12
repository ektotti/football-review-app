<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Log;

use function Psy\debug;

class GetPostsController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = [];

        if ($request->tag_name) {
            $postsQuelyBuilder = Post::getByTagName($request->tag_name);
            $posts = $postsQuelyBuilder->simplePaginate(3);
            return $posts;
        }

        $refererUrl = parse_url($_SERVER['HTTP_REFERER']);
        $refererPath = $refererUrl['path'];
        if (preg_match("/\/user\/\d+/", $refererPath)) {
            $user_id = str_replace("/user/", "", $refererPath);
            $posts = Post::where('user_id', $user_id)->with(['user', 'fixture', 'comments.user', 'likes'])->simplePaginate(3);
            return $posts;
        } else {
            $posts = Post::with(['user', 'fixture', 'comments.user', 'likes'])->simplePaginate(3);
            return $posts;
        }
    }
}
