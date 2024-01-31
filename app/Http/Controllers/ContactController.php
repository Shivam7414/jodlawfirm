<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactController extends Controller
{
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone_no' => 'required|digits:10',
                'subject' => 'required'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $contactUs = new ContactUs();
            $contactUs->name = $request->name;
            $contactUs->phone_no = $request->phone_no;
            $contactUs->subject = $request->subject;
            $contactUs->status = 'pending';
            $contactUs->save();
            
            return back()->with('success', 'Your message has been sent successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
