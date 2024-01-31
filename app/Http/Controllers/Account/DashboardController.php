<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::where('user_id', auth()->user()->id)
            ->with('applicationSetting')
            ->latest()
            ->take(4)
            ->get();
        return view('account.dashboard.index', compact('applications'));
    }
}
