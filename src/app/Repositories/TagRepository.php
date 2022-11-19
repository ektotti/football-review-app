<?php
namespace App\Repositories;

use App\Tag;
use Illuminate\Support\Facades\Log;

class TagRepository implements TagRepositoryInterface {
    public function store($tagName)
    {
        Log::debug($tagName[0]);
        $tagArray = [];
        array_push($tagArray, $tagName);
        Log::debug($tagArray);
        $tag = Tag::firstOrCreate(['tag_name' => $tagName[0]]);
        return $tag;
    } 

    public function getByName($tagName)
    {
        return Tag::where('tag_name', "#$tagName")->has('post')->with(['post'])->get();
    }
}