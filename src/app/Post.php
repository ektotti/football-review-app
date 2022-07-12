<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Tag;


class Post extends Model
{
    protected $guarded = [
        'id',
    ];

    public function fixture() {
        return $this->belongsTo('App\Fixture');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
}

    public function checkUserLikePost () {
        
        $filtered = $this->likes->filter(function($value, $key) {
            $loginUser = Auth::user();
            return $value->user_id == $loginUser->id;
        });
        if($filtered->count()){
            return true;
        }
        return false;
    } 

    static function getByTagName($tagName) {
        $tag = Tag::where('tag_name', "#$tagName")->with(['post'])->get();

            $postIds = [];
            foreach ($tag[0]->post as $post) {
                array_push($postIds, $post->pivot->post_id);
            };
            $postsQuelyBuilder = Post::wherein('id', $postIds)->with(['user', 'fixture', 'comments.user', 'likes']);
            return $postsQuelyBuilder;
    }

    public function checkIsSelf () {
        $loginUser = Auth::user();
        return $this->user_id === $loginUser->id;
    }
}
