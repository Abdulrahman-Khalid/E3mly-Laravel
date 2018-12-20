<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function user() { //relationship in laravel user() in Post.php and posts in User.php
        $this->belongsTo('App\User');
    }
    //public function project() { //relationship in laravel user() in Post.php and posts in User.php
    //    $this->belongsTo('App\Project');
    //}
}
