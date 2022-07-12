<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $guarded = [
        'id',
    ];

    public function followingUser() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function followedUser() {
        return $this->belongsTo('App\User', 'following_user_id', 'id');
    }
    static function getFollowingUserList($userId) {
        $followingUserList = [];
        $followingUsers = Relationship::where('user_id',$userId)->with('followedUser')->get();
        for($i = 0; $i < $followingUsers->count(); $i++) {
            $followingUserList[] = $followingUsers[$i]->followedUser->toArray();
        }
        return $followingUserList;
    }

    static function getFollowedUserList($userId) {
        $followedUserList = [];
        $followedUsers = Relationship::where('following_user_id',$userId)->get();
        for($i = 0; $i < $followedUsers->count(); $i++) {
            $followedUserList[] = $followedUsers[$i]->followingUser;
        }
        return $followedUserList;
    }
}
