<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function index(Request $request){
        $status = $request->status;
        $type = $request->type;
        $applications = Application::where('user_id', auth()->user()->id)
        ->when($status, function($query, $status){
            return $query->where('status', $status);
        })
        ->when($type, function($query, $type){
            return $query->where('type', $type);
        })
        ->get();

        return view('account.application.index', compact('applications'));
    }

    public function detail(Request $request, $id){
        $application = Application::findOrfail($id);

        return view('account.application.detail', compact('application'));
    }

    public function apply(Request $request){
        $applicationSetting = ApplicationSetting::where('type', $request->type)->first();
        if(!$applicationSetting){
            return abort(404);
        }
        return view('account.application.apply', compact('applicationSetting', 'request'));
    }

    public function uploadDocument(Request $request){

        return view('account.application.modal.upload_documents', compact('request'));
    }

    public function showDocument(Request $request){
        $application = Application::findOrfail($request->application_id);

        return view('account.application.modules.show_documents', compact('application'));
    }
}
