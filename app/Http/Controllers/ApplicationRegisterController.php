<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use App\Models\User;

class ApplicationRegisterController extends Controller
{
    public function index(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();
        if(!$ApplicationSetting){
            abort(404);
        }

        if(Session::has('user_otp')){
            Session::remove('user_otp');
        }
        if(Session::has('user_info')){
            Session::remove('user_info');
        }

        return view('frontend.application_register.index', compact('ApplicationSetting', 'request'));
    }

    public function storeUser(Request $request){
        $user = User::where('phone_no', $request->phone_no)->orwhere('email', $request->email)->first();
        if(!$user){
            $user = new User();
        }

        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = Hash::make('12345678');
        $user->phone_no = $request->phone_no;
        $user->phone_verified_at = now();
        $user->save();

        Session::put('userInfo', [
            'id' => $user->id,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'password' => 12345678,
            'phone_no' => $user->phone_no,
        ]);

        return redirect('trademark/payment?type='.$request->type);
    }

    public function payment(Request $request){
        if(!Session::has('userInfo')){
            return redirect('trademark/index?type='.$request->type);
        }

        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();
        if(!$ApplicationSetting){
            abort(404);
        }

        return view('frontend.application_register.payment', compact('ApplicationSetting', 'request'));
    }
}
