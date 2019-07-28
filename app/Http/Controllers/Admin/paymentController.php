<?php

namespace App\Http\Controllers\Admin;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class paymentController extends Controller
{

    public function index()
    {
        $payments= Payment::with('user')->wherePayment(1)->latest()->paginate(10);
        return view('Admin.payments.all' , compact('payments'));
    }

    public function unSuccessfull()
    {
        $payments= Payment::with('user')->wherePayment(0)->latest()->paginate(10);
        return view('Admin.payments.failure' , compact('payments'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, Payment $payment)
    {
        //agar be soorate khodkar update nashod ma inja be soorat dasti update mikonim
        $payment->update([
            'payment' => 1
        ]);
        //alert()
        return back();
    }


    public function destroy(Payment $payment)
    {
        $payment->delete();
        //alart()
        return back();
    }
}
