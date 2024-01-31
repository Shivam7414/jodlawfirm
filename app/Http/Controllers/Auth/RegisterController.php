<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravolt\Avatar\Avatar;
use App\Traits\EmailTrait;
use App\Traits\SmsTrait;
use App\Models\User;

class RegisterController extends Controller
{
    use EmailTrait;
    public function create(Request $request)
    {
        if(Session::has('user_information')){
            Session::forget('user_information');
        }
        return view('auth.register', compact('request'));
    }

    public function store(Request $request) {
        $attributes = request()->validate([
            'full_name' => 'required|regex:/^[\pL\s]+$/u|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone_no' => 'required|numeric|digits:10|unique:users,phone_no',
            'password' => 'required|min:8|max:255',
        ]);

        $attributes['password'] = Hash::make($attributes['password']);

        Session::put('user_information', $attributes);

        $emailOtp = random_int(100000, 999999);

        $to = $attributes['email'];
        $subject = 'Sign up for '.config('app.name'). '-Email Verification';
        $emailContent = 'Your email verification code is: '.$emailOtp;
        
        $response =  $this->sendEmail($to, $subject, $emailContent);

        Session::put('otp', [
            'email_otp' => $emailOtp,
            'email_otp_verified' => false,
        ]);

        return redirect()->route('otp.verify', ['redirect_after_login' => $request->redirect_after_login]);
    }

    public function otpVerify(Request $request){
        if(!Session::has('otp')){
            return redirect()->route('register')->with('error', 'Please fill the registration form first.');
        }
        return view('auth.otp_verify', compact('request'));
    }

    public function validateOtp(Request $request){
        if($request->otp_type == 'email'){
            if(Session::get('otp')['email_otp'] == $request->otp){
                Session::put('otp.email_otp_verified', true);
                Session::put('user_information.email_verified_at', now());
                return response()->json(['success' => true, 'type' => 'email', 'message' =>'Email otp verified successfully.'], 200);
            }else{
                return response()->json(['success' => false, 'type' => 'phone', 'message' =>'Email otp not matched.'], 422);
            }
        }
    }

    public function otpVerifyPerform(Request $request) {
        if(Session::get('otp')['email_otp_verified'] == true){ 
            $user = User::create(Session::get('user_information'));
            $avatar = new Avatar();
            $randomColor = '#' . dechex(rand(0x000000, 0xFFFFFF));
            $avatar_name = str_replace(' ', '_', $user->full_name);
            $avatar->create($user->full_name)->setBackground($randomColor)->setShape('square')->save('storage/profile_image/'.$avatar_name.$user->id.'.jpg', 100);
            $user->profile = 'profile_image/'.$avatar_name.$user->id.'.jpg';
            $user->save();
            auth()->login($user);

            Session::forget('user_information');
            Session::forget('otp');

            $redirects = [
                'trademark_registration' => 'trademark/index?type=registration',
                'trademark_objection' => 'trademark/index?type=objection',
                'trademark_opposition' => 'trademark/index?type=opposition',
                'trademark_renewal' => 'trademark/index?type=renewal',
            ];
            
            $redirect = $redirects[$request->redirect_after_login] ?? 'account/dashboard/index';
            
            return redirect()->intended($redirect);
        }
    }    
}
