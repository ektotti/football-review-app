<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class IdentityProvider extends Model
{
    function user(){
        return $this->belongsTo(User::class);
    }
}
