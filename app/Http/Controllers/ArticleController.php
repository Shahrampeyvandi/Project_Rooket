<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
class ArticleController extends Controller
{
    public function single(Article $article)
    {
        $article->increment('viewCount');
//       dd( Article::whereSlug($slug)->firstOrFail());
       $comments= $article->comments()->where(['published' => 1 , 'parent_id' => 0])->with('comments')->latest()->get();

        return view('Home.article' , compact(['article','comments']));

    }
}
