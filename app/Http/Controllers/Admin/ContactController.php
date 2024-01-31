<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $status = request('status');
        $perPage = request('per_page', 10);
        $contactUs = ContactUs::orderBy('id', 'desc')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->paginate($perPage);

        return view('admin.contact_us.index', compact('request', 'contactUs'));
    }

    public function changeStatus(Request $request, $id)
    {
        try{
            $contactUs = ContactUs::find($id);
            $contactUs->status = $request->status;
            $contactUs->save();

            return response()->json([
                'status' => $contactUs->status,
                'success' => true,
                'message' => 'Status changed successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}
