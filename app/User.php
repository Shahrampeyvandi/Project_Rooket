<?php

namespace App;

use Carbon\Carbon;
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
        'name', 'email', 'password', 'active','api_token','viptime','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token','viptime'
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
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function checkLearning($course)
    {
        return !! learning::where(['user_id' => $this->id ,'course_id' => $course->id])->first();
    }
    public function isActive()
    {
        return $this->viptime > Carbon::now() ? true : false;
    }
}
