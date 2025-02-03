<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Uuid;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Storage;

class OcrController extends Controller
{
    public function index()
    {
        return view('ocr.ocr-recognize');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showImage($id)
    {
        $fileUpload = FileUpload::find($id);
        $filePath = 'storage/' . $fileUpload->file_name;
        $filePath = str_replace('"', '', $filePath);
        return response()->file($filePath);
    }

    public function saveResult($request)
    {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        Storage::putFileAs('file_store', $file, $filename);
    }
}
