<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserActivation;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'phone';
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        if(auth()->validate($request->only('phone' , 'password'))) {
            $user = User::wherePhone($request->input('phone'))->first();
            if($user->active == 0 ) {
                $checkActiveCode = $user->activationCode()->where('expire' , '>=' , Carbon::now() )->latest()->first();

                if($checkActiveCode) {
                    if($checkActiveCode->expire > Carbon::now() ) {
                        $this->incrementLoginAttempts($request);
                        return back()->withErrors(['code' => 'پیامک تایید به شماره تلفن شما ارسال شده است .لطفا 15 دقیقه دیگر مجددا تلاش نمایید!']);
                    }
                } else {
                    event(new UserActivation($user));
                }
            }
        }


        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of courses, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

        //------------register with google account---------------


    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $social_user = Socialite::driver('google')->stateless()->user();
       
        $user = User::whereEmail($social_user->getEmail())->first();


        if( ! $user ) {
            $user = User::create([
                'name' => $social_user->getName(),
                'email' => $social_user->getEmail(),
                'password' => bcrypt($social_user->getId())
            ]);
        }

        if($user->active == 0) {
            $user->update([
                'active' => 1
            ]);
        }

        auth()->loginUsingId($user->id);
        alert()->success('شما با موفقیت وارد شدید');
        return redirect('/');
    }

    //------- custom validate Login -------------//
    
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required',
             'password' => 'required',
//             'g-recaptcha-response' => 'recaptcha'
        ]);
    }
}
