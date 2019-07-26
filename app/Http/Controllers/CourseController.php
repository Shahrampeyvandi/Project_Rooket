<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
class CourseController extends Controller
{
    public function single(Course $course)
    {

       $course->increment('viewCount');
       $comments= $course->comments()->where(['published'=>1, 'parent_id'=>0])->latest()->get();

       return view('Home.courses' , compact(['course','comments']));

    }
}
