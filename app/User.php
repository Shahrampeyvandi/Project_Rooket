<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable , HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    public function article()
    {
        return $this->hasMany(Article::class);
    }

    public function activationCode()
    {
        return $this->hasMany(ActivationCode::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function isAdmin()
    {
        return $this->level == 'admin' ? true : false;
    }
}
