<?php

namespace App\Repositories;

interface PostRepositoryInterface {
    public function storePost($postDetails);
    public function storeTags($tags);
    public function getPostById($postId);
    public function getByTagName($tagName);
    public function getByUserId($userId);
    public function getFollowingPost($userId);
    public function getAllPost();
}