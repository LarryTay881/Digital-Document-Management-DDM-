<?php
    
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Storage;
use DB;
use Uuid;
use Carbon\Carbon;
use App\Models\FileUpload;
use Brian2694\Toastr\Facades\Toastr;
  
class WebcamController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('form.form-webcam-capture');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $img = $request->image;
        $folderPath = "file_store/";
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = uniqid() . '.png';
        
        $file = $folderPath . $file_name;
        Storage::put($file, $image_base64);

        DB::beginTransaction();
        $uploadby = Auth::user()->name;
        $dt = Carbon::now();
        $date_time = $dt->toDayDateTimeString();
        $folder_name = "file_store";
        $saveRecord = new FileUpload;
        $saveRecord->upload_by = $uploadby;
        $saveRecord->date_time = $date_time;
        $saveRecord->file_name = $file_name;
        $saveRecord->uuid = Uuid::generate(5,$date_time . $file_name .$folder_name, Uuid::NS_DNS);
        Storage::put($file, $image_base64);
        $saveRecord->save();
        DB::commit();
        Toastr::success('Captured image has been uploaded successfully :)','Success');
        return redirect()->back();
    }
}