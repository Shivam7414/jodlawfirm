<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = request('per_page', 10);
        $users = User::orderBy('id', 'desc')->paginate($perPage);

        return view('admin.user.index', compact('users'));
    }

    public function detail($id)
    {
        return view('admin.user.detail');
    }

    public function edit(Request $request, $id = null)
    {
        if($id) {
            $user = User::findOrFail($id);
        }else{
            $user = new User();
        }

        return view('admin.user.edit', compact('user'));
    }

    public function store(Request $request){
        if($request->id) {
            $user = User::findOrFail($request->id);
        }else{
            $user = new User();
        }

        $user->full_name = $request->full_name;
        $user->email = $request->email;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->phone_no = $request->phone_no;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->save();

        return redirect('admin/user/index')->with('success', 'User saved successfully');
    }
}
