<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Repositories\PostRepositoryInterface;

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

        return $this->postRepository->storePost($postDetails);
    }

    public function storeTagsAndRelateToPost($postText, $postId)
    {
        $tags = $this->getTagsFromText($postText);
        if (!$tags) {
            return false;
        } else {
            $tagIds = $this->storeTags($tags);
        }
        $post = $this->postRepository->getPostById($postId);
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
}
