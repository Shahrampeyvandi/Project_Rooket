<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Course;
use Carbon\Carbon;
class HomeController extends Controller
{

    public function index()
    {

        // use cache
        if(cache()->has('articles')){
            $articles=cache('articles');
        }else{
            $articles= Article::latest()->take(4)->get();
            cache(['articles'=>$articles], Carbon::now()->addMinutes(2) );
        }
        if(cache()->has('courses')){
            $courses= cache('courses');
        }else{
            $courses= Course::latest()->take(4)->get();
            cache(['courses'=>$courses], Carbon::now()->addMinutes(2) );

        }

        return view('Home.index' , compact(['articles','courses']));
    }
}
