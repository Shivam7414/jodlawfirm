<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use App\Models\Application;
use Razorpay\Api\Api;
use App\Models\User;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = request('per_page', 10);
        $searchQuery = request('search_query', null);
        $status = request('status', null);
        $type = request('type', null);
        
        $applications = Application::orderBy('id', 'desc')
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'full_name', 'email');
                },
                'applicationSetting' => function ($query) {
                    $query->select('id', 'type', 'price1_name', 'price2_name');
                }
            ])
            ->when($searchQuery, function ($query, $searchQuery) {
                return $this->applySearchFilters($query, $searchQuery);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->paginate($perPage);
        return view('admin.application.index', compact('request', 'applications'));
    }

    private function applySearchFilters($query, $searchQuery) 
    {
        return $query->where('id', $searchQuery)
            ->orWhereHas('user', function ($query) use ($searchQuery) {
                $query->where('full_name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('phone_no', 'LIKE', '%' . $searchQuery . '%');
            });
    }

    public function add(Request $request)
    {
        $applicationSettings = ApplicationSetting::all();
        $users = User::select('id','full_name','email')->get();
        $userOptions = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->full_name,
                'nameorEmail' => $user->full_name . ' - ' . $user->email,
            ];
        })->toArray();
        return view('admin.application.add', compact('request', 'applicationSettings', 'userOptions'));
    }

    public function detail(Request $request, $id)
    {
        $application = Application::findorfail($id);
        return view('admin.application.detail', compact('application'));
    }

    public function changeStatus(Request $request, $id)
    {
        $application = Application::findorfail($id);
        $application->status = $request->status;
        $application->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status changed successfully'
        ]);
    }
    public function showUserDocuments(Request $request)
    {
        $application = Application::findOrfail($request->application_id);
        return view('admin.application.modules.user_documents', compact('application'));
    }

    public function showAdminDocuments(Request $request)
    {
        $application = Application::findOrfail($request->application_id);
        return view('admin.application.modules.admin_documents', compact('application'));
    }

    public function uploadUserDocuments(Request $request)
    {
        return view('admin.application.modal.upload_documents', compact('request'));
    }

    public function generatePaymentLink(Request $request)
    {
        $key_id = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        $api = new Api($key_id, $secret);

        $paymentUrl = $api->paymentLink->create(array(
            'amount' => $request->amount * 100, 'currency' => 'INR', 'accept_partial' => false,
            'first_min_partial_amount' => 100, 'description' => 'For XYZ purpose', 'customer' => array(
                'name' => $request->name,
                'email' => $request->email, 'contact' => $request->phone
            ),  'notify' => array('sms' => true, 'email' => true),
            'reminder_enable' => true,
            'callback_url' => url('payment_url_callback'),
        ));

        return response()->json([
            'status' => 'success',
            'message' => 'Payment link generated successfully',
            'payment_link' => $paymentUrl->short_url
        ]);
    }

    public function searchUsers(Request $request)
    {
        $users = User::search($request->search_query)->get();
        return response()->json($users);
    }
}
