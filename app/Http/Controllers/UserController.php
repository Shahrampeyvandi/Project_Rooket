<?php

namespace App\Http\Controllers;

use App\ActivationCode;
use Artesaos\SEOTools\Contracts\SEOFriendly;
use Carbon\Carbon;
use SEO;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function activation($token)
    {
        $activationCode = ActivationCode::whereCode($token)->first();

        if(! $activationCode) {
            dd('not exist');

            return redirect('/');
        }

        if($activationCode->expire < Carbon::now()) {
            dd('expire');
            return redirect('/');
        }

        if($activationCode->used == true) {
            dd('used');
            return redirect('/');
        }

        $activationCode->user()->update([
            'active' => 1
        ]);

        $activationCode->update([
            'used' => true
        ]);

        auth()->loginUsingId($activationCode->user->id);
        return redirect(route('login'));
    }

    public function index()
    {
        SEO::setTitle('پنل کاربری');
        SEO::setDescription('اطلاعات حساب کاربران');
        return view('Home.panel.index');
    }

    public function history()
    {
        SEO::setTitle('پنل کاربری');
        SEO::setDescription('اطلاعات حساب کاربران');
        $payments = auth()->user()->payments()->latest()->paginate(20);

        return view('Home.panel.history' , compact('payments'));
    }

    public function vip()
    {
        return view('Home.panel.vip');
    }
}
