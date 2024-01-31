<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.dashboard');
    }

    public function home() {
        return view('frontend.index');
    }

    public function workingVideo() {
        $video_link = "https://www.youtube.com/embed/8pdRNwGr_SY?si=NzPayZAWZR31FAMG";
        return view('frontend.modal.working_video', compact('video_link'));
    }

    public function page(Request $request, $slug) {
        $page = Page::where('slug', $slug)->first();
        if(!$page) {
            abort(404);
        }
        return view('frontend.page', compact('request', 'page'));
    }
}
