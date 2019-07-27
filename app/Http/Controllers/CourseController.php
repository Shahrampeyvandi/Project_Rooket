<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Course;
class CourseController extends Controller
{
    protected $MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX'; //Req

    public function single(Course $course)
    {

        $course->increment('viewCount');
        $comments = $course->comments()->where(['published' => 1, 'parent_id' => 0])->latest()->get();

        return view('Home.courses', compact(['course', 'comments']));

    }

    public function paymant(Request $request)
    {
        validate($request, [
            'course_id' => 'required'
        ]);

        $course = Course::findOrFail($request->course_id);
        if ($course->price == 0 && $course->type == 'vip') {
            alert()->error('این محصول شامل شما نمیشود')->persistent('تایید');
        }

        $Price = $course->price;
        $Description = "توضیحات پرداخت";
        $Email = auth()->user()->email;
        $CallbackURL = 'http://www.yoursoteaddress.ir/verify.php'; // Required

        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

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
            auth()->user()->payments()->create([
                'resnumber' => $result->Authority,
                'course_id' => $course->id,
                'price' => $Price
            ]);
            return redirect("https://www.zarinpal.com/pg/StartPay/.$result->Authority");
        } else {
            echo 'ERR: ' . $result->Status;
        }
    }

    public function checkpayment()
    {
        $Authority = \request('Authority');
        $payment = Payment::whereResnumber($Authority)->firstOrFail();
        if (request('Status') == 'OK') {

            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $this->MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $payment->price,
                ]
            );

            if ($result->Status == 100) {
                echo 'Transaction success. RefID:' . $result->RefID;
            } else {
                echo 'Transaction failed. Status:' . $result->Status;
            }
        } else {
            echo 'Transaction canceled by user';
        }
    }

}
