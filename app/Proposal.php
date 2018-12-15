<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    public function user() { //relationship in laravel user() in Proposal.php and Proposal in User.php
        $this->belongsTo('App\User');
    }
    public function post() { //relationship in laravel post() in Proposal.php and Proposal in Post.php
        $this->belongsTo('App\Post');
    }
}
