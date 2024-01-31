<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Transaction;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function getOrderId(Request $request) {
        try {
            $request->validate([
                'type' => 'required',
                'price' => 'required'
            ]);

            $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();
            $amount = $request->price == '1' ? $ApplicationSetting->discounted_price1_amount : $ApplicationSetting->discounted_price2_amount;
            $orderData = [
                'amount'  => $amount * 100,
                'currency' => 'INR'
            ];

            $key_id = config('services.razorpay.key');
            $secret = config('services.razorpay.secret');
            
            $api = new Api($key_id, $secret);
            $razorpayOrder = $api->order->create($orderData);

            if(Session::has('applicationInfo')){
                Session::remove('applicationInfo');
            }

            Session::put('applicationInfo', [
                'type' => $request->type,
                'price' => $request->price,
            ]);

            return response()->json($razorpayOrder->id, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function callBack(Request $request) {
        $key_id = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        $api = new Api($key_id, $secret);
        $applicationInfo = Session::get('applicationInfo');

        $api->utility->verifyPaymentSignature(array('razorpay_order_id' => $request->razorpay_order_id, 'razorpay_payment_id' => $request->razorpay_payment_id, 'razorpay_signature' => $request->razorpay_signature));
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        $transaction = new Transaction();
        $application = new Application();

        $transaction->user_id = auth()->user()->id;
        $transaction->payment_id = $payment->id;
        // $transaction->bank_transaction_id = $payment->acquirer_data->bank_transaction_id; // this is not working
        $transaction->order_id = $payment->order_id;
        $transaction->method = $payment->method;
        $transaction->amount = $payment->amount;
        $transaction->fee = $payment->fee;
        $transaction->tax = $payment->tax;
        $transaction->status = $payment->status;
        $transaction->captured = $payment->captured;
        $transaction->save();

        $application->user_id = auth()->user()->id;
        $application->transaction_id = $transaction->id;
        $application->type = $applicationInfo['type'];
        $application->price = $applicationInfo['price'];
        $application->status = 'pending';
        $application->save();

        return redirect()->route('account.application.index')->with('success', 'Application created successfully');
    }
}