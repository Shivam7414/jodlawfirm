<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request){
        return view('account.profile');
    }

    public function profileUpdate(Request $request){
        if($request->email != auth()->user()->email){
            $request->validate([
                'email' => 'required|email|unique:users',
            ]);
        }
        if($request->password){
            $request->validate([
                'password' => 'required|min:8',
            ]);
        }
        $user = auth()->user();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function profileImageUpdate(Request $request){
        $user = auth()->user();
    
        try {
            $request->validate([
                'file' => 'required|mimes:jpg,png,jpeg|max:2048',
            ]);
    
            if($request->file()) {
                $fileName = time().'_'.$request->file->getClientOriginalName();
                $filePath = 'profile_image/'.$fileName;
                if(Storage::disk('public')->put($filePath, file_get_contents($request->file))) {
                    $user->profile = 'storage/'.$filePath;
                    $user->save();
    
                    return response()->json(['success' => true, 'message' => 'Profile uploaded successfully.', 'file' => $fileName], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'File upload failed: ' . $e->getMessage()], 500);
        }
    }

    public function profileImageDelete(Request $request){
        $user = auth()->user();
        if($user->profile != 'img/icons/default_user.png'){
            Storage::disk('public')->delete($user->profile);
            $user->profile = 'img/icons/default_user.png';
            $user->save();
            return response()->json(['success' => true, 'message' => 'Profile image deleted successfully.'], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'Profile image already removed.'], 200);
        }

        return back()->with('success', 'Profile image deleted successfully.');
    }
}
