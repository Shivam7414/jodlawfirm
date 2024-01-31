<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show(Request $request)
    {
        return view('auth.login', compact('request'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);
 
		if (Auth::guard('web')->attempt($credentials)) {
			$request->session()->regenerate();
            $redirects = [
                'trademark_registration' => 'trademark/index?type=registration',
                'trademark_objection' => 'trademark/index?type=objection',
                'trademark_opposition' => 'trademark/index?type=opposition',
                'trademark_renewal' => 'trademark/index?type=renewal',
            ];
            
            $redirect = $redirects[$request->redirect_after_login] ?? 'account/dashboard/index';
            
            return redirect()->intended($redirect);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
