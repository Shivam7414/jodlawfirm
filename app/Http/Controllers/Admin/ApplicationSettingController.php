<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationSettingController extends Controller
{
    public function index(Request $request){
        $validTypes = ['registration', 'objection', 'opposition', 'renewal'];
        abort_unless(in_array($request->type, $validTypes), 404);
    
        $applications = Application::where('type', $request->type)
            ->with(['transaction', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    
        $applicationsUsersCount = $applications->unique('user_id')->count();
        $totalApplicationsRevenue = $applications->sum(function ($application) {
            return $application->transaction->amount;
        });
    
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();
    
        return view('admin.application_settings.index', compact('ApplicationSetting', 'request', 'applications', 'applicationsUsersCount','totalApplicationsRevenue'));
    }

    public function price1Setting(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();
        if(!$ApplicationSetting){
            $ApplicationSetting = new ApplicationSetting;
        }

        return view('admin.application_settings.modal.price1_setting', compact('ApplicationSetting', 'request'));
    }
    public function price1SettingStore(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();

        if(!$ApplicationSetting){
            $ApplicationSetting = new ApplicationSetting;
            $ApplicationSetting->type = $request->type;
        }

        $ApplicationSetting->price1_name = $request->price1_name;
        $ApplicationSetting->price1_content = $request->price1_content;
        $ApplicationSetting->actual_price1_amount = $request->actual_price1_amount;
        $ApplicationSetting->discounted_price1_amount = $request->discounted_price1_amount;
        $ApplicationSetting->save();

        return back()->with('success', 'Trademark settings saved successfully.');
    }

    public function price2Setting(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();
        if(!$ApplicationSetting){
            $ApplicationSetting = new ApplicationSetting;
        }
        return view('admin.application_settings.modal.price2_setting', compact('ApplicationSetting', 'request'));
    }
    public function price2SettingStore(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();

        if(!$ApplicationSetting){
            $ApplicationSetting = new ApplicationSetting;
            $ApplicationSetting->type = $request->type;
        }

        $ApplicationSetting->price2_name = $request->price2_name;
        $ApplicationSetting->price2_content = $request->price2_content;
        $ApplicationSetting->actual_price2_amount = $request->actual_price2_amount;
        $ApplicationSetting->discounted_price2_amount = $request->discounted_price2_amount;
        $ApplicationSetting->save();

        return back()->with('success', 'Trademark settings saved successfully.');
    }

    public function requiredDocuments(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->select('required_documents')->first();

        return view('admin.application_settings.modal.required_documents', compact('request', 'ApplicationSetting'));
    }
    public function requiredDocumentsStore(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();

        if(!$ApplicationSetting){
            $ApplicationSetting = new ApplicationSetting;
            $ApplicationSetting->type = $request->type;
        }

        $ApplicationSetting->required_documents = $request->required_documents;
        $ApplicationSetting->save();

        return back()->with('success', 'Trademark settings saved successfully.');
    }

    public function storeContent(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->first();

        if(!$ApplicationSetting){
            $ApplicationSetting = new ApplicationSetting;
            $ApplicationSetting->type = $request->type;
        }

        $ApplicationSetting->content = $request->content;
        $ApplicationSetting->save();
        return back()->with('success', 'Content saved successfully.');
    }

    public function addYoutubeVideo(Request $request){
        $ApplicationSetting = ApplicationSetting::where('type', $request->type)->select('youtube_videos')->first();

        return view('admin.application_settings.modal.youtube_videos', compact('ApplicationSetting', 'request'));
    }

    function getYoutubeEmbedUrl($url)
    {
        $videoId = $this->getYoutubeVideoId($url);

        return "https://www.youtube.com/embed/{$videoId}";
    }

    function getYoutubeVideoId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    public function storeYoutubeVideo(Request $request)
    {
        $application = ApplicationSetting::where('type', $request->type)->first();
        
        if($request->youtube_video){
            $embeddedUrls = array_map([$this, 'getYoutubeEmbedUrl'], $request->youtube_video);
            $application->youtube_videos = $embeddedUrls;
        }else{
            $application->youtube_videos = [];
        }

        $application->save();

        return back()->with('success', 'Youtube video added successfully.');
    }
}
