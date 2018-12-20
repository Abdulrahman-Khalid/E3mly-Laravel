<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user() { //relationship in laravel user() in Post.php and posts in User.php
        $this->belongsTo('App\User');
    }

    public function proposal(){
        $this->hasMany('App\proposal');
    }
}
