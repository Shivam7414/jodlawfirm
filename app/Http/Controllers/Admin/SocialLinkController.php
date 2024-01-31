<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::all();
        return view('admin.social_link.index', compact('socialLinks'));
    }

    public function store(Request $request){
        foreach (['instagram', 'linkedin', 'youtube', 'facebook', 'twitter'] as $index => $key) {
            $socialLink = SocialLink::firstWhere('name', $key);
    
            if ($socialLink) {
                $socialLink->link = $request->link[$index];
                $socialLink->status = $request->status[$index];
                $socialLink->save();
            } else {
                SocialLink::create([
                    'name' => $key,
                    'link' => $request->link[$index],
                    'status' => $request->status[$index],
                ]);
            }
        }

        return back()->with('success', 'Social links saved successfully');
    }
}
