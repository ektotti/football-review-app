<?php

namespace App\Repositories;

interface PostRepositoryInterface {
    public function storePost($postDetails);
    public function getById($id);
    public function getByIds($ids);
    public function getByUserId($userId);
    public function getFollowingPost($userId);
    public function getAllPost();
    public function delete($id);
}