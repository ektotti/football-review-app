<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use App\Post;
use Illuminate\Support\Facades\Log;
use Exception;

class PostService
{

    public $postRepository;
    public $tagRepository;
    public function __construct(PostRepositoryInterface $postRepository, TagRepositoryInterface $tagRepository)
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
    }

    public function storePost($request, $fixtureId, $imageUrls)
    {
        $user = Auth::user();
        $postDetails = [
            'user_id' => $user->id,
            'fixture_id' => $fixtureId,
            'title' => $request->title,
            'body' => $request->textContent
        ];

        $i = 1;
        foreach ($imageUrls as $imageUrl) {
            $postDetails["image{$i}"] = $imageUrl;
            $i++;
        }
        $post = new Post();
        $post->fill($postDetails);
        return $this->postRepository->storePost($post);
    }

    public function getSearchedPosts($tagName)
    {
        $tag = $this->tagRepository->getByName($tagName);
        if (empty($tag->toArray())) throw new Exception("タグが存在しません。", 1);

        $postIds = [];
        foreach ($tag[0]->post as $post) {
            array_push($postIds, $post->pivot->post_id);
        };
        return $this->postRepository->getByIds($postIds);
    }

    public function getUserPagePosts($refererPath)
    {
        $userId = str_replace("/user/", "", $refererPath);
        return $this->postRepository->getByUserId($userId);
    }

    public function getIndexPosts()
    {
        // return Auth::check() ? $this->postRepository->getFollowingPost(Auth::user()->id) : $this->postRepository->getAllPost();
        return $this->postRepository->getAllPost();
    }

    public function getById($id)
    {
        return $this->postRepository->getById($id);
    }

    public function updatePost($request, $editedPostId)
    {
        $selectedPost = $this->getById($editedPostId);
        $selectedPost->body = $request->body;
        $selectedPost->title = $request->title;

        return $this->postRepository->storePost($selectedPost);
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }
}
