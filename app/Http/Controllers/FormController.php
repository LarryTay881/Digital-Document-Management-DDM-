<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uuid;
use Carbon\Carbon;
use App\Models\FormInput;
use App\Models\FileUpload;
use App\Models\FormField;
use Brian2694\Toastr\Facades\Toastr;
use PDF;
use Excel;
use App\Exports\FormInputExport;
use App\Exports\FileUploadExport;
use App\Exports\FormListExport;

class FormController extends Controller
{
    /** form index */
    public function formIndex()
    {
        return view('form.form-input');
    }

    /** save record */
    public function formSaveRecord(Request $request)
    {
        $request->validate([
            'full_name'   => 'required|string|max:255',
            'gender'      => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'state'       => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'country'     => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
        ]);

        DB::beginTransaction();
        try {
            $saveRecord = new FormInput;
            $saveRecord->full_name   = $request->full_name;
            $saveRecord->gender      = $request->gender;
            $saveRecord->address     = $request->address;
            $saveRecord->state       = $request->state;
            $saveRecord->city        = $request->city;
            $saveRecord->country     = $request->country;
            $saveRecord->postal_code = $request->postal_code;
            $saveRecord->date_of_birth = $request->date_of_birth;
            $saveRecord->save();
            DB::commit();
            Toastr::success('Data has been saved successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Data save fail :)','Error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $data = $request->input('form_data');
        $formData = json_decode($data, true);

        foreach ($formData as $field) {
            $formField = new FormField($field);
            $formField->save();
        }

        return response()->json(['message' => 'Form data saved successfully.']);
        // Toastr::success('Data has been updated successfully :)','Success');
    }

    /** page form view */
    public function formView()
    {
        $dataFormInput = FormInput::all();
        return view('pageview.form-input-table',compact('dataFormInput'));
    }

    /** page edit form input */
    public function formInputEdit($id)
    {
        $formInputView = FormInput::where('id',$id)->first();
        return view('pageview.form-input-edit',compact('formInputView'));
    }

    /** update record form input */
    public function formUpdateRecord(Request $request)
    {
        $request->validate([
            'full_name'   => 'required|string|max:255',
            'gender'      => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'state'       => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'country'     => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
        ]);

        DB::beginTransaction();
        try {

            $updateRecord = [
                'full_name'   => $request->full_name,
                'gender'      => $request->gender,
                'address'     => $request->address,
                'state'       => $request->state,
                'city'        => $request->city,
                'country'     => $request->country,
                'postal_code' => $request->postal_code,
                'date_of_birth' => $request->date_of_birth,
            ];
            
            FormInput::where('id',$request->id)->update($updateRecord);

            DB::commit();
            Toastr::success('Data has been updated successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Data update fail :)','Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function formDelete(Request $request)
    {
        try {
            FormInput::destroy($request->id);
            Toastr::success('Data has been deleted successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Data delete fail :)','Error');
            return redirect()->back();
        }
    }

    /** form upload file index */
    public function formUpdateIndex()
    {
        return view('form.form-upload-file');
    }

    /** update file */
    public function formFileUpdate(Request $request) 
    {
        $request->validate([
            'file_name' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $dt = Carbon::now();
            $date_time = $dt->toDayDateTimeString();
            $folder_name = "file_store";
            \Storage::disk('local')->makeDirectory($folder_name, 0775, true); // create directory
            if($request->hasFile('file_name'))
            {
                foreach($request->file_name as $photos) {
                    $file_name = $photos->getClientOriginalName(); // get file original name
                    $saveRecord = new FileUpload;
                    $saveRecord->upload_by = Auth::user()->name;
                    $saveRecord->date_time = $date_time;
                    $saveRecord->file_name = $file_name;
                    $saveRecord->uuid = Uuid::generate(5,$date_time . $file_name .$folder_name, Uuid::NS_DNS);
                    \Storage::disk('local')->put($folder_name.'/'.$file_name,file_get_contents($photos->getRealPath()));
                    $saveRecord->save();
                }
                DB::commit();
                Toastr::success('Image file has been uploaded successfully :)','Success');
                return redirect()->back();
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Image file upload fail :(','Error');
            return redirect()->back();
        }
    }

    /** view file upload */
    public function formFileView()
    {
        if(Auth::user()->role_name == "Admin"){
            $fileUpload = FileUpload::all();
        }
        else{
            $upload_by = Auth::user()->name;
            $fileUpload = FileUpload::where('upload_by', $upload_by)->get();
        }
        return view('pageview.view-file-upload-table',compact('fileUpload'));
    }

    /** file upload */
    public function fileDownload($file_name)
    {
        $fileDownload = FileUpload::where('file_name',$file_name)->first();
        $download     = storage_path("app/file_store/{$fileDownload->file_name}");
        return \Response::download($download);
    }

    /** delete record and remove file in folder */
    public function fileDelete(Request $request)
    {
        try {
            FileUpload::destroy($request->id);
            unlink(storage_path("app/file_store/".$request->file_name));
            Toastr::success('Data has been deleted successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Data delete fail :)','Error');
            return redirect()->back();
        }
    }

    public function generateEmployeeReport($format = 'pdf'){
        // Fetch data for the report (e.g., form input records)
        $data = DB::table('form_inputs')->get();
    
        // Generate the report based on the selected format
        if($format == 'pdf') {
            $pdf = PDF::loadView('reports.employee-form-report', ['data' => $data]);
            return $pdf->download('employee-form-report.pdf');
        } elseif ($format === 'excel') {
            // Generate Excel report
            return Excel::download(new FormInputExport, 'employee-form-report.xlsx');
        } else {
            abort(404);
        }
    }

    public function generateFileUploadReport($format = 'pdf'){
        // Fetch data for the report (e.g., file upload records)
        $data = DB::table('file_uploads')->get();
    
        // Generate the report based on the selected format
        if ($format == 'pdf') {
            $pdf = PDF::loadView('reports.upload-form-report', ['data' => $data]);
            return $pdf->download('upload-form-report.pdf');
        } elseif ($format === 'excel') {
            // Generate Excel report using the new export class
            return Excel::download(new FileUploadExport, 'upload-form-report.xlsx');
        } else {
            abort(404);
        }
    }
    
    public function generateFormResponseReport($format = 'pdf'){
        // Fetch data for the report (e.g., form template records)
        $data = DB::table('form_templates')->get();
    
        // Generate the report based on the selected format
        if ($format === 'pdf') {
            $pdf = PDF::loadView('reports.form-list-response', ['data' => $data]);
            return $pdf->download('form-list-report.pdf');
        } elseif ($format === 'excel') {
            // Generate Excel report using the new export class
            return Excel::download(new FormListExport, 'form-list-report.xlsx');
        } else {
            abort(404);
        }
    }    
}
