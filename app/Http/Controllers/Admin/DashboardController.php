<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Application;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request){
        $year = $request->get('year', 2024);
        $applications = Application::selectRaw('YEAR(created_at) year, MONTH(created_at) month, type, COUNT(*) data')
        ->whereYear('created_at', $year)
        ->groupBy('year', 'month', 'type')
        ->get();

        $totalUsersCount = User::count();
        $yearUsersCount = User::whereYear('created_at', now()->year)->count();
        $monthMoneySum = Transaction::whereMonth('created_at', now()->month)->sum('amount');
        $totalMoneySum = Transaction::sum('amount');

    return view('admin.dashboard.index', compact('applications', 'year', 'totalUsersCount', 'yearUsersCount', 'monthMoneySum', 'totalMoneySum'));
    }
}
