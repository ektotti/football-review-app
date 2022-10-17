<?php

namespace App\Repositories;

use App\Post;
use App\Tag;

class PostRepository implements PostRepositoryInterface
{
    public function storePost($postDetails)
    {
        $post = new Post();
        if ($post->fill($postDetails)->save()) {
            return $post->id;
        } else {
            return false;
        }
    }

    public function getPostById($postId)
    {
        return Post::find($postId);
    }

    public function storeTags($tags) {
        $tagIds = [];
        foreach ($tags as $tag) {
            $insertedTag = Tag::firstOrCreate(['tag_name' => $tag],[]);
            array_push($tagIds, $insertedTag->id);
        }
        return $tagIds;
    }
}
