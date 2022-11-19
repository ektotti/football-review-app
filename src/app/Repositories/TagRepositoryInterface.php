<?php
namespace App\Repositories;

interface TagRepositoryInterface {
    public function store($tagName); 
    public function getByName($tagName); 
}