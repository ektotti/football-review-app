<?php

namespace App\Repositories;

use App\Http\Resources\PostCollection;
use App\Post;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

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

    public function getById($id)
    {
        return Post::with(['user', 'fixture', 'comments.user', 'likes'])->find($id);
    }

    public function getByIds($ids = [])
    {
        return Post::wherein('id', $ids)
            ->with(['user', 'fixture', 'comments.user', 'likes'])
            ->orderby('updated_at', 'desc')
            ->simplePaginate(5);
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
