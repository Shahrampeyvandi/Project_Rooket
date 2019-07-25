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

}
