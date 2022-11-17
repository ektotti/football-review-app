<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Repositories\PostRepositoryInterface;
use App\Post;

class PostService
{

    public $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
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

    public function storeTagsAndRelateToPost($postModel)
    {
        $tags = $this->getTagsFromText($postModel->textContent);
        if (!$tags) return;

        $tagIds = $this->storeTags($tags);
        $post = $this->postRepository->getPostById($postModel->id);
        $post->tags()->sync($tagIds);
    }

    public function getTagsFromText($postText)
    {
        preg_match_all("/#[０-９0-9A-Za-zぁ-んァ-ヶ\一-龠々\ー\-\・]+/u", $postText, $matches);
        if (!$matches[0]) {
            return false;
        }

        return $matches;
    }

    public function storeTags($tags)
    {
        return $this->postRepository->storeTags($tags);
    }

    public function getSearchedPosts($tagName)
    {
        return $this->postRepository->getByTagName($tagName);
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
        return $this->postRepository->getPostById($id);
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
