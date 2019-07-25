<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
class CourseController extends Controller
{
    public function single(Course $course)
    {
        dd(response(['courses'=>$course]) );
    }
}
