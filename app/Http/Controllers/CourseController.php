<?php

namespace App\Http\Controllers;

use App\learning;
use App\Payment;
use Illuminate\Http\Request;
use App\Course;
class CourseController extends Controller
{
    protected $MerchantID = '00'; //Req

    public function single(Course $course)
    {

        $course->increment('viewCount');
        $comments = $course->comments()->where(['published' => 1, 'parent_id' => 0])->latest()->get();

        return view('Home.courses', compact(['course', 'comments']));

    }

    public function paymant(Request $request)
    {
        \validator($request->all(), [
            'course_id' => 'required'
        ]);

        $course = Course::findOrFail($request->course_id);

        if (auth()->user()->checkLearning($course)){
            alert()->error('این محصول قبلا توسط شما خریداری شده است    ')->persistent('تایید');
         return back();
        }
        if ($course->price == 0 && $course->type == 'vip') {
            alert()->error('این محصول شامل شما نمیشود')->persistent('تایید');
            return back();
        }

        $Price = $course->price;
        $Description = "توضیحات پرداخت";
        $Email = auth()->user()->email;
        $Mobile= "09999999999";
        $CallbackURL = 'http://www.yoursoteaddress.ir/verify.php'; // Required

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
                'course_id' => $course->id,
                'price' => $Price
            ]);
            return redirect("https://www.zarinpal.com/pg/StartPay/.$result->Authority");
        } else {
            //لیست اررور ها موجود در زرین پال
            echo 'ERR: ' . $result->Status;
        }
    }

    public function checkpayment()
    {
        $Authority = request('Authority');
        $payment = Payment::whereResnumber($Authority)->firstOrFail();
        $course= Course::findOrFail($payment->course_id);
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
            if ($this->addCourseToLearning($payment , $course)) {
                alert()->success('خرید با موفقیت انجام شد');
                return redirect($course->path());
            }
            } else {
                print_r("not done");
            }
        } else {
            echo 'Transaction canceled by user';
        }
    }
    protected function addCourseToLearning($payment , $course)
    {
        $payment->updated([
           'payment' => 1
        ]);

        learning::create([
           'user_id' => auth()->user()->id,
           'course_id' => $course->id
        ]);

        return true;
    }
}
