<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
class CourseController extends Controller
{
    public function single(Course $course)
    {

       $course->increment('viewCount');

       return view('Home.courses' , compact('course'));



    }
}
