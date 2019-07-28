<?php

namespace App\Providers;

use App\Comment;
use App\Payment;
use function foo\func;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $client= new \GuzzleHttp\Client();
            $response= $client->request('POST','https://google.com/recaptcha/api/siteverify',[
                'form_params' =>[
                    'secret'=> config('services.recaptcha.secret'), //secret key
                    'response'=>$value, //وقتی تیک زده میشود
                    'remote_ip'=>request()->ip(),
                    ]
                    ]); 
                    $response=json_decode($response->getBody());
                    // dd($response->success);
           return $response->success;
        });
// pass variable to view
        view()->composer('Admin.section.header' , function($view){
           $unPublishedCommentCount=count( Comment::where('published', 0)->latest()->get());
           $unsuccessfulPayments=count(Payment::wherePayment(0)->latest()->get());
           $view->with([ 'unPublishedCommentCount' => $unPublishedCommentCount ,
               'unsuccessfulPayments' => $unsuccessfulPayments]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
