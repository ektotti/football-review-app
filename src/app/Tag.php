<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function post() {
            return $this->belongsToMany('App\Post')->withPivot('post_id');
    }

    public $guarded = [
        'id'
    ];

    static function saveTagsAndGetIdsFromText($text){
        preg_match_all("/#[０-９0-9A-Za-zぁ-んァ-ヶ一-龠々]+/u", $text, $matches);
        
        if(!$matches[0]){
            return false;
        }
        
        $tagIds = [];
        foreach ($matches[0] as $match) {
            $tag = Tag::firstOrCreate(['tag_name' => $match],[]);
            array_push($tagIds, $tag->id);
        }
        return $tagIds;

    }
}
