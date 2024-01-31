<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiCredential;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class ApiCredentialController extends Controller
{
    public function index(Request $request)
    {
        $apiCredentials = ApiCredential::whereIn('name', ['test_razorpay_key_id', 'test_razorpay_key_secret','live_razorpay_key_id', 'live_razorpay_key_secret', 'mail_from_name', 'mail_from_email_address', 'brevo_email_login', 'brevo_smtp_password'])->pluck('value', 'name');
        $paymentModeStatus = SiteSetting::whereIn('name', ['payment_mode_status'])->pluck('value', 'name');
        
        return view('admin.api_credential.index', compact('apiCredentials', 'paymentModeStatus'));
    }

    public function store(Request $request){
        $data = $request->all();
        foreach($data as $key => $value){
            if($value && $key != '_token'){
                ApiCredential::updateOrCreate(
                    ['name' => $key],
                    ['value' => $value]
                );
            }
        }
        return back()->with('success', 'Api credentials updated successfully');
    }

    public function updatePaymentModeStatus(Request $request){
        $siteSetting = SiteSetting::where('name', 'payment_mode_status')->first();
        if(!$siteSetting){
            $siteSetting = new SiteSetting();
            $siteSetting->name = 'payment_mode_status';
        }

        $siteSetting->value = $request->status;
        $siteSetting->save();

        return response()->json(['success' => true, 'message' => 'Payment mode status updated successfully']);
    }
}
