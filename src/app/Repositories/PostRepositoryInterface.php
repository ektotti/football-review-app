<?php

namespace App\Repositories;

interface PostRepositoryInterface {
    public function storePost($postDetails);
    public function storeTags($tags);
    public function getPostById($postId);
}