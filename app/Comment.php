<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable= [
      'user_id','parent_id','published','comment','commentable_id','commentable_type'
    ];
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class , 'parent_id', 'id')->where('published', 1)->latest();
    }

    public function setCommentAttribute($value)
    {
        return $this->attributes['comment']= str_replace(PHP_EOL, "<br>", $value);
    }


}
