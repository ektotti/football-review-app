<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function checkIsSelf()
    {
        $loginUser = Auth::user();
        if(!$loginUser) return false;
        return $this->user_id === $loginUser->id;
    }
}
