<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function index(Request $request){
        $site_settings = SiteSetting::whereIn('name', ['site_name', 'copyright_year', 'company_address', 'support_email', 'support_phone_no', 'whatsapp_number', 'favicon', 'logo'])->pluck('value', 'name');

        return view('admin.site_settings.index', compact('site_settings'));
    }

    public function store(Request $request){
        $data = $request->all();
        foreach($data as $key => $value){
            if($value && $key != '_token'){
                SiteSetting::updateOrCreate(
                    ['name' => $key],
                    ['value' => $value]
                );
            }
        }
        return back()->with('success', 'Site settings updated successfully');
    }

    public function fileUpload(Request $request){
        try {
            $request->validate([
                'file' => 'required|mimes:jpg,png,jpeg|max:2048',
            ]);
    
            if($request->file()) {
                $fileName = time().'_'.$request->file->getClientOriginalName();
                $filePath = 'uploads/'.$fileName;
                if(Storage::disk('public')->put($filePath, file_get_contents($request->file))){
                    $siteSetting = SiteSetting::where('name', $request->file_type)->first();
                    if($siteSetting){
                        $siteSetting->update(['value' => 'storage/'.$filePath]);
                    }else{
                        SiteSetting::create(['name' => $request->file_type, 'value' => 'storage/'.$filePath]);
                    }
                }
    
                return response()->json(['success' => true, 'message' => 'File has been uploaded.', 'file' => $fileName], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'File upload failed: ' . $e->getMessage()], 500);
        }
    }
}
