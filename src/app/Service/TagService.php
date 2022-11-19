<?php
namespace App\Service;

use App\Repositories\TagRepositoryInterface;

class TagService{
    public $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository) {
        $this->tagRepository = $tagRepository;
    }

    public function storeTags($postModel)
    {
        $tags = $this->getTagsFromText($postModel->body);
        if (!$tags) return;

        $tagIds = [];
        foreach ($tags as $tag) {
            $insertedTag = $this->tagRepository->store($tag);
            array_push($tagIds, $insertedTag->id);
        }
        return $tagIds;
    }

    public function getTagsFromText($postBody)
    {
        preg_match_all("/#[０-９0-9A-Za-zぁ-んァ-ヶ\一-龠々\ー\-\・]+/u", $postBody, $matches);
        if (!$matches[0]) return false;
        
        return $matches;
    }
}