<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\IdentityProvider;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','nickname','icon_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function identityProviders() {
        return $this->hasMany(IdentityProvider::class);
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }
    
    public function followingUser() {
        return $this->hasMany('App\Relationship', 'user_id', 'id');
    }

    public function followedUser() {
        return $this->hasMany('App\Relationship', 'following_user_id', 'id');
    }

    public function isfollowingOrNot($selectedUser) {
        $hasRelation = Relationship::where('user_id', $this->id)->where('following_user_id', $selectedUser->id)->first();
        if($hasRelation){
            return true;
        } else {
            return false;
        }
    }
    
    public function likes() {
        return $this->hasMany('App\Like');
    }

}
