<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //ower write reset()
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        $tokenData = DB::table(config('auth.passwords.users.table'))->whereToken($request->input('token'))->first();
        $user = User::wherePhone($tokenData->phone)->first();
      if ($user && $user->phone == $request->input('phone')){
          $user->update([
             'password' => bcrypt($request->input('password')) ,
          ]);
        Auth::guard()->login($user , true); // true for remember me
          return redirect($this->redirectTo);
      }
      return back()->withErrors('phone' , 'اطلاعات شما صحیح نمی باشد');
    }


    // over write rule()
    protected function rules()
    {
        return [
            'token' => 'required',
            'phone' => 'required|digits:11',
            'password' => 'required|confirmed|min:8',
        ];
    }

    // over write showResetForm()
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'phone' => $request->phone]
        );
    }
}
