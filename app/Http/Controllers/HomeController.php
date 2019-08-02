<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Jobs\sendMail;
use App\User;
use Illuminate\Http\Request;
use App\Article;
use App\Course;
use Carbon\Carbon;
use SEO;
class HomeController extends Controller
{

    public function index()
    {
        //php artisan queue:table
//        $job = new sendMail(User::find(1) , 'fffaffd');
//        $this->dispatch($job);
//        $job->delay(Carbon::now()->addSeconds(10));


//        $job = (new sendMail(User::find(1) , 'fffaffd'))->onQueue('send.mails');
// we can fix a name for queue and execute with flag --queue=name

        //dar database etelaat zakhire mishavand
        //php aartisan queue:work
        //php artiasn queue:failed  => table where queue are failed
        //php artisan queue:retry all or id




        SEO::setTitle('Home');
        SEO::setDescription('This is my page description');

        // use cache
        if(cache()->has('articles')){
            $articles=cache('articles');
        }else{
            $articles= Article::latest()->take(4)->get();
            cache(['articles'=> $articles], Carbon::now()->addMinutes(1) );
        }
        if(cache()->has('courses')){
            $courses= cache('courses');
        }else{
            $courses= Course::latest()->take(4)->get();
            cache(['courses'=>$courses], Carbon::now()->addMinutes(1) );

        }

        return view('Home.index' , compact(['articles','courses']));
    }

    public function comment(Request $request)
    {

            $request->validate([
                'comment'=> 'required | max:1500',

            ]);

         auth()->user()->comments()->create($request->all());
         return back()->with('sendComment','پیام شما ارسال شد');

    }
}
