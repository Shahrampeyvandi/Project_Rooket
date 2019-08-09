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

    public function scopeSearch($query , $keywords)
    {
        //ما میتوانیم یک جدول جدا برای tags ایجاد کنیم(خارج از این موضوع)
        //search in categoty-name , title , tags
$query->whereHas('categoreis' ,function ($query) use ($keywords){
    $query->where('name' , 'LIKE' ,'%'.$keywords.'%' );

 })->orWhere('title' ,'LIKE' ,'%'.$keywords.'%' )
    ->orWhere('tags' ,'LIKE' ,'%'.$keywords.'%' );
        return $query;
    }

    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoreis(){
        return $this->belongsToMany(Category::class);
    }

}
