<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Traits\SmsTrait;
use App\Traits\EmailTrait;

class OtpController extends Controller
{
    use SmsTrait;
    use EmailTrait;
    public function send(Request $request){
        try{
            $this->validate($request, [
                'phone_no' => 'required|numeric|digits:10',
            ]);
            $otp = random_int(100000, 999999);
            // $response = $this->sendSms($otp, 7414887589);
            if(Session::has('otp')){
                Session::remove('otp');
            }
            Session::put('otp', $otp);
            
            return response()->json(['success' => true, 'message' =>'Otp sent successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
        
    }

    public function verify(Request $request){
        if(Session::get('otp') == $request->otp){
            return response()->json('Otp verified successfully.', 200);
        }else{
            return response()->json('Otp verified successfully.', 422);
        }
    }
}
