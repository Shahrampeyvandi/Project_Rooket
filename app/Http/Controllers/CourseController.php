<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
class CourseController extends Controller
{
    public function single(Course $course)
    {

       $course->update(['viewCount'=> $course->viewCount+1]);
       dd($course);

    }
}
