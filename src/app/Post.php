<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Tag;
use App\Relationship;
use Illuminate\Support\Facades\Log;
use function Psy\debug;

class Post extends Model
{
    protected $guarded = [
        'id',
    ];

    public function fixture()
    {
        return $this->belongsTo('App\Fixture');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function checkUserLikePost()
    {

        $filtered = $this->likes->filter(function ($value, $key) {
            $loginUser = Auth::user();
            return $value->user_id == $loginUser->id;
        });
        if ($filtered->count()) {
            return true;
        }
        return false;
    }

    // static function getByTagName($tagName)
    // {
    //     $tag = Tag::where('tag_name', "#$tagName")->has('post')->with(['post'])->get();
    //     Log::debug($tag);
    //     if (empty($tag->toArray())) {
    //         Log::debug('タグなし');
    //         return false;
    //     }
    //     $postIds = [];
    //     foreach ($tag[0]->post as $post) {
    //         array_push($postIds, $post->pivot->post_id);
    //     };
    //     return Post::wherein('id', $postIds)->with(['user', 'fixture', 'comments.user', 'likes'])->orderby('updated_at', 'desc');
    // }

    // static function getByUserId($userId)
    // {
    //     return Post::where('user_id', $userId)->with(['user', 'fixture', 'comments.user', 'likes'])->orderby('updated_at', 'desc');
    // }

    // static function getAllIndexPost()
    // {
    //     return Post::with(['user', 'fixture', 'comments.user', 'likes'])->orderby('updated_at', 'desc');
    // }

    // static function getFollowingPost($userId)
    // {
    //     $followingUserId = Relationship::where('user_id', $userId)->get()->pluck('following_user_id');
    //     $followingUserIdList = $followingUserId->toArray();
    //     array_push($followingUserIdList, $userId);
    //     return Post::with(['user', 'fixture', 'comments.user', 'likes'])->whereIn('user_id', $followingUserIdList)->orderby('updated_at', 'desc');
    // }

    public function checkIsSelf()
    {
        $loginUser = Auth::user();
        return $this->user_id === $loginUser->id;
    }
}
