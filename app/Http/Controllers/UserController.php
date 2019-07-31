<?php

namespace App\Http\Controllers;

use App\ActivationCode;
use App\Payment;
use Artesaos\SEOTools\Contracts\SEOFriendly;
use Carbon\Carbon;
use SEO;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $MerchantID = '00'; //Req

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
        //vip route in panel user
        return view('Home.panel.vip');
    }
    public function payment()
    {
        \validator(request()->all(), [
            'panel' => 'required'
        ]);

        // ---- set price ---
        switch (\request('plan')){

            case 3:
                $Price=30000;
                break;
            case 12:
                $Price=100000;
                break;
            default:
                $Price=10000;


        }



        $Description = "توضیحات پرداخت";
        $Email = auth()->user()->email;
        $Mobile= "09999999999";
        $CallbackURL = url(route('user.paymentchecker')); // Required

        $client = new \SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentRequest(
            [
                'MerchantID' => $this->MerchantID,
                'Amount' => $Price,
                'Description' => $Description,
                'Email' => $Email,
                'Mobile' => $Mobile,
                'CallbackURL' => $CallbackURL,
            ]
        );
        if ($result->Status == 100) {
            //ذخیره اطلاعات قبل از پرداخت
            auth()->user()->payments()->create([
                'resnumber' => $result->Authority,
                'price' => $Price
                // course_id => 'vip' (default)
            ]);
            return redirect("https://www.zarinpal.com/pg/StartPay/.$result->Authority");
        } else {
            //لیست اررور ها موجود در زرین پال
            echo 'ERR: ' . $result->Status;
        }

    }
    public function checker()
    {
        $Authority = request('Authority');
        $payment = Payment::whereResnumber($Authority)->firstOrFail();
        if (request('Status') == 'OK') {
//تصدیق اطلاعات وارد شده
            $client = new \SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $this->MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $payment->price,
                ]
            );

           if ($result->Status == 100){
               if ($this->checkVip($payment)) {
                   alert()->success(' با موفقیت انجام شد');
                   return redirect(route('user.panel'));
               }
               } else {
                   echo "Transaction failed: " . $result->Status;
               }
           } else {
               echo 'Transaction canceled by user';
           }
    }
    protected function checkVip($payment )
    {
        $payment->updated([
            'payment' => 1
        ]);
        switch ($payment->price){
            case 10000:
                $time=1;
                break;
            case 30000:
                $time=3;
                break;
            case 100000:
                $time=12;
                break;
            default:
                $time=1;
        }

        $user=$payment->user;
        $viptime= $user->isActive() ? Carbon::parse($user->viptime) : Carbon::now();
        $user->update([
            'viptime' => $viptime->addMonths($time),
        ]);
        return true;
    }


}
