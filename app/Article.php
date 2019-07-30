<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Sluggable;

    protected $guarded = [];

    protected $casts = [
        'images' => 'array'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function path()
    {
        return "/article/$this->slug";
    }

    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
