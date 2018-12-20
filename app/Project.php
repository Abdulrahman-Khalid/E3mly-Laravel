<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function post() { //relationship in laravel post() in Project.php and user in User.php
        $this->belongsTo('App\User');
    }
}
