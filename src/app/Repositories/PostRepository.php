<?php

namespace App\Repositories;

use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Post;
use App\Tag;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

use function PHPUnit\Framework\throwException;

class PostRepository implements PostRepositoryInterface
{
    public function storePost($postModel)
    {
        if ($postModel->save()) {
            Log::debug($postModel);
            return $postModel;
        } else {
            throw new Exception("保存ができませんでした。");
        }
    }

    public function getPostById($postId)
    {
        return Post::with(['user', 'fixture', 'comments.user', 'likes'])->find($postId);
    }

    public function storeTags($tags)
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $insertedTag = Tag::firstOrCreate(['tag_name' => $tag], []);
            array_push($tagIds, $insertedTag->id);
        }
        return $tagIds;
    }

    public function getByTagName($tagName)
    {
        $tag = Tag::where('tag_name', "#$tagName")->has('post')->with(['post'])->get();
        if (empty($tag->toArray())) {
            throw new Exception("タグが存在しません。", 1);
        }
        $postIds = [];
        foreach ($tag[0]->post as $post) {
            array_push($postIds, $post->pivot->post_id);
        };
        return new PostCollection(Post::wherein('id', $postIds)
            ->with(['user', 'fixture', 'comments.user', 'likes'])
            ->orderby('updated_at', 'desc')
            ->simplePaginate(5));
    }

    public function getByUserId($userId)
    {
        return Post::where('user_id', $userId)
            ->with(['user', 'fixture', 'comments.user', 'likes'])
            ->orderby('updated_at', 'desc')
            ->simplePaginate(5);
    }

    public function getFollowingPost($userId)
    {
        $followingUserId = Relationship::where('user_id', $userId)->get()->pluck('following_user_id');
        $followingUserIdList = $followingUserId->toArray();
        array_push($followingUserIdList, $userId);
        return Post::with(['user', 'fixture', 'comments.user', 'likes'])
            ->whereIn('user_id', $followingUserIdList)
            ->orderby('updated_at', 'desc')
            ->simplePaginate(5);
    }

    public function getAllPost()
    {
        return Post::with(['user', 'fixture', 'comments.user', 'likes'])
            ->orderby('updated_at', 'desc')
            ->simplePaginate(5);
    }

    public function delete($id)
    {
       if(!Post::destroy($id)) throw new Exception('何かがおかしいようです。投稿が削除できませんでした。');
       return true;
    }
}
