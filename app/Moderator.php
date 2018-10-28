<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ModeratorResetPasswordNotification;

class Moderator extends Authenticatable
{
    use Notifiable;
    protected $guard = 'moderator'; //important for the middleware('auth:moderator')

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birthdate','bio', 'gender', 'country', 'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token) //override sendPasswordResetNotification  
    {
        $this->notify(new ModeratorResetPasswordNotification($token));
    }

}