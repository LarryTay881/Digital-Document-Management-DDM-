<?php
    
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Storage;
use DB;
use Uuid;
use Carbon\Carbon;
use App\Models\OcrResult;
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
        return view('form.form-ocr-result');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $dt = Carbon::now();
            $date_time = $dt->toDayDateTimeString();
            $folder_name = "uploads";
            \Storage::disk('local')->makeDirectory($folder_name, 0775, true); // create directory
            if($request->hasFile('file_name'))
            {
                foreach($request->file_name as $ocrresult) {
                    $file_name = $ocrresult->getClientOriginalName(); // get file original name
                    $saveRecord = new OcrResult;
                    $saveRecord->upload_by = Auth::user()->name;
                    $saveRecord->date_time = $date_time;
                    $saveRecord->file_name = $file_name;
                    $saveRecord->uuid = Uuid::generate(5,$date_time . $file_name .$folder_name, Uuid::NS_DNS);
                    \Storage::disk('local')->put($folder_name.'/'.$file_name,file_get_contents($ocrresult->getRealPath()));
                    $saveRecord->save();
                }
                DB::commit();
                Toastr::success('OCR result file has been uploaded successfully :)','Success');
                return redirect()->back();
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('OCR result file upload fail :(','Error');
            return redirect()->back();
        }
    }
}