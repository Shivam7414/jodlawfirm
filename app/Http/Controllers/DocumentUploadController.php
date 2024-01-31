<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DocumentUploadController extends Controller
{
    public function storeUserDocuments(Request $request){
        $document = new Document();
        $document->user_id = auth()->user()->id;
        $document->type = $request->type;
        $document->type_id = $request->type_id;

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $fileExtension = $request->file->getClientOriginalExtension();
            $filePath = 'documents/user'.$fileName;
            if(Storage::disk('public')->put($filePath, file_get_contents($request->file))) {
                $document->name = $fileName;
                $document->original_name = $request->file->getClientOriginalName();
                $document->path = 'storage/'.$filePath;
                $document->size = $request->file->getSize();
                $document->extension = $fileExtension;
                $document->save();
                return response()->json(['success' => true, 'file' => $request->file->getClientOriginalName()], 200);
            }
        }
    }

    public function storeAdminDocuments(Request $request){
        $document = new Document();
        $document->user_id = auth()->guard('admin')->user()->id;
        $document->type = $request->type;
        $document->type_id = $request->type_id;

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $fileExtension = $request->file->getClientOriginalExtension();
            $filePath = 'documents/admin'.$fileName;
            if(Storage::disk('public')->put($filePath, file_get_contents($request->file))) {
                $document->name = $fileName;
                $document->original_name = $request->file->getClientOriginalName();
                $document->path = 'storage/'.$filePath;
                $document->size = $request->file->getSize();
                $document->extension = $fileExtension;
                $document->save();
                return response()->json(['success' => true, 'file' => $request->file->getClientOriginalName()], 200);
            }
        }
    }

    public function deleteDocument(Request $request){
        try{
            $document = Document::find($request->id);
            if($document){
                Storage::disk('public')->delete($document->path);
                $document->delete();
                return response()->json(['success' => true], 200);
            }
        }catch(\Exception $e){
            return response()->json(['success' => false], 422);
        }
    }
}
