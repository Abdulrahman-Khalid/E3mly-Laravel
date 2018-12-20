<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birthdate','bio','points', 'doneProjects', 'gender', 'country', 'profile_picture', 'CV_file',
        'rating', 'num_finished_projects',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function posts(){
        $this->hasMany('App\Post');
    }
    public function messages(){
        $this->hasMany('App\Message');
    }
    public function proposals(){
        $this->hasMany('App\Proposal');
    }

    public function projects(){
        $this->hasMany('App\Project');
    }
}