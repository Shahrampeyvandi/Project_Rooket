<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
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

    public function scopeFilter($query)
    {
//        $query like $this
        $category=\request('category');

        if (isset($category) && trim($category) != '' && $category != 'all'){
            $query->whereHas('categories' , function ($query) use ($category){
                $query->whereId($category);
            });
        }

        $type = request('type');
        if (isset($type) && trim($type) != ''){
            if (in_array($type , ['free' , 'cach' , 'vip'])){
                $query->whereType($type);
            }
        }

        if (request('order') == '1'){
            $query->orderBy('viewCount')->get();

        }else{
            $query->latest();
        }
        return $query;
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['description'] = str_limit(preg_replace('/<[^>]*>/' , '' , $value) , 200);
        $this->attributes['body'] = $value;
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function path()
    {
        return "/courses/$this->slug";
    }

    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable');
    }
}
