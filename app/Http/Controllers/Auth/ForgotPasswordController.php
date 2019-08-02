<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar;
use Kavenegar\KavenegarApi;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // for overwrite view for forget password section
//    public function showLinkRequestForm()
//    {
//        return view('auth.passwords.email');
//    }

public function sendResetLinkPhone(Request $request)
{
    $this->validatePhone($request);
    $user = User::wherePhone($request->input('phone'))->first();
    $token = Str::random(20);

    if ($user){
            $this->createToken($user , config('auth.passwords.users.table') ,$token); //this method create token and return it
            try{
//                $api = new KavenegarApi("7345753639564B705137654C55547468506264663452413179447A567441726D");
//                 $api->send('10004346' , $user->phone , route('password.reset' , $token) );
                Kavenegar::Send('10004346',$user->phone,route('password.reset' , $token));
//                dd(route('password.reset' , $token));
            }catch(\Kavenegar\Exceptions\ApiException $e){
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
            catch(\Kavenegar\Exceptions\HttpException $e){
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
            return back()->with('success' , 'لینک فعال سازی برای شما پیامک شد');
    }
    return back();


}
private function createToken($user , $tableName ,$token)
{
    $passwordTable = DB::table($tableName);
    $password=$passwordTable->wherePhone($user->phone);
    if ($password->first()){
            $password->update([
                'token' =>$token ,
                'created_at' => Carbon::now()
            ]);
    }else{
            $passwordTable->insert([
                'phone' => $user->phone,
                'token' =>$token ,
                'created_at' => Carbon::now()
            ]);
    }
    return $token;
}

    protected function validatePhone(Request $request)
    {
        $request->validate(['phone' => 'required|digits:11']);
    }

}
