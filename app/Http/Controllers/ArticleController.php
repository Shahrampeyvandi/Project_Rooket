<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
class ArticleController extends Controller
{
    public function single(Article $article)
    {
        $article->increment('viewCount');

        return view('Home.article' , compact('article'));

    }
}
