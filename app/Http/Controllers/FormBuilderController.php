<?php
    
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Models\FormTemplate;
use App\Models\FormResponse;
use App\Exports\FormResponseExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CustomEmail;

class FormBuilderController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('form.form-builder');
    }
    public function saveData(Request $request)
    {
        DB::beginTransaction();
        try {
            $uploadby = Auth::user()->name;
            $dt = Carbon::now();
            $date_time = $dt->toDayDateTimeString(); 
            $saveRecord = new FormTemplate;
            $saveRecord->template_name = $request->templateName;
            $saveRecord->upload_by = $uploadby;
            $saveRecord->date_time = $date_time;
            $saveRecord->form_data = $request->formData;
            $saveRecord->save();    
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return $e;
        }
        return $request->formData;
    }
    public function updateTemplate(Request $request)
    {
        $id = $request->id;
        $upload_by = Auth::user()->name;
        $dt = Carbon::now();
        $date_time = $dt->toDayDateTimeString();
        $form_data = $request->formData;
        $updateRecord = [
            'id'                  => $id,
            'upload_by'           => $upload_by,
            'date_time'           => $date_time,
            'form_data'           => $form_data,
        ];
        FormTemplate::where('id', $request->id)->update($updateRecord);
        Toastr::success('Template updated successfully :)','Success');
        return response()->json(["status" => "Template updated successfully"]);
    }
    public function deleteTemplate(Request $request)
    {
        try {
            FOrmTemplate::destroy($request->id);
            Toastr::success('Template has been deleted successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Template delete fail :)','Error');
            return redirect()->back();
        }
    }
    public function templateView()
    {
        if(Auth::user()->role_name == "Admin"){
            $dataTemplate = FormTemplate::all();
        }
        else{
            $upload_by = Auth::user()->name;
            $dataTemplate = FormTemplate::where('upload_by', $upload_by)->get();
        }
        return view('form.form-view',compact('dataTemplate'));
    }
    public function templateEdit($id)
    {
        $dataTemplate = FormTemplate::where('id', $id)->first();
        return view('form.form-builder', ['form_data' => $dataTemplate->form_data, 'template_name' => $dataTemplate->template_name, 'id' => $id]);
    }
    public function serveForm($id) {
        $dataTemplate = FormTemplate::where('id', $id)->first();
        return view('form.view-form', ['form_data' => $dataTemplate->form_data, 'template_name' => $dataTemplate->template_name, 'template_id' => $id]);
    }
    public function sendForm(Request $request)
    {
        $email = $request->input('email');
        $subject = $request->input('subject');
        $body = $request->input('body');

        // Send email using Laravel Mail class
        Mail::to($email)->send(new CustomEmail($subject, $body));

        return response()->json(['message' => 'Form Link sent successfully']);
    }
    public function formLink($id) {
        $dataTemplate = FormTemplate::where('id', $id)->first();
        return view('form.form-link', ['form_data' => $dataTemplate->form_data, 'template_name' => $dataTemplate->template_name]);
    }
    public function formList()
    {
        if(Auth::user()->role_name == "Admin"){
            $dataTemplate = FormTemplate::all();
        }
        else{
            $upload_by = Auth::user()->name;
            $dataTemplate = FormTemplate::where('upload_by', $upload_by)->get();
        }
        return view('form.form-list',compact('dataTemplate'));
    }
    public function formResponse($id)
    {
        $dataTemplate = FormTemplate::where('id', $id)->first();
        $dataResponse = FormResponse::where('template_id', $id)->get();
        $formFields = json_decode(json_decode($dataTemplate->form_data, true, 2));
        $formName = $dataTemplate->template_name;
        // $fields = array_column($formFields, 'label');
        $fields = [];
        foreach ($formFields as $field) {
        if (!in_array($field->type, ['header', 'button', 'hidden', 'paragraph'])) {
            $fields[] = $field->label;
        }
    }
        $formResponses = $dataResponse->pluck('form_response')->toArray();
        $responses = array_map('json_decode', $formResponses);
       
        return view('form.form-response', compact('dataTemplate', 'dataResponse', 'fields', 'responses', 'formName'));
    }
    public function formSubmit(Request $request)
    {    
        if (Auth::check()) {
            $uploadby = Auth::user()->name;
        } else {
            $uploadby = "";
        }
        DB::beginTransaction();
        try {
            $dt = Carbon::now();
            $date_time = $dt->toDayDateTimeString(); 
            $formResponse = new FormResponse;
            $formResponse->upload_by = $uploadby;
            $formResponse->date_time = $date_time;
            $formResponse->form_response = $request->formData;
            $formResponse->template_id = $request->id;
            $formResponse->save();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return $e;
        }
        return $request->formData;
    }
    public function ocrTemplate(Request $request)
    {
        DB::beginTransaction();
        try {
            $uploadby = Auth::user()->name;
            $dt = Carbon::now();
            $date_time = $dt->toDayDateTimeString(); 
            $formData = json_encode($request->input('formData'));
            $saveRecord = new FormTemplate;
            $saveRecord->upload_by = $uploadby;
            $saveRecord->date_time = $date_time;
            $saveRecord->form_data = $formData;
            $saveRecord->template_name = $request->input('templateName');
            $saveRecord->save();    
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return $e;
        }
        return $formData;
    }
    public function ocrResponse(Request $request)
    {
        DB::beginTransaction();
        try {
            $uploadby = Auth::user()->name;
            $dt = Carbon::now();
            $date_time = $dt->toDayDateTimeString(); 
            $templateId = $request->input('templateId');
            $formResponse = new FormResponse;
            $formResponse->upload_by = $uploadby;
            $formResponse->date_time = $date_time;
            $formResponse->form_response = json_encode($request->input('formData'));
            $formResponse->template_id = $templateId;
            $formResponse->save();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return $e;
        }
        return $request->formData;
    }

    public function getTemplateList()
    {
        $templates = FormTemplate::all();
        return response()->json(['templates' => $templates]);
    }
    public function getTemplateFields(Request $request)
    {
        $templateId = $request->input('templateId');
        $templateData = FormTemplate::where('id', $templateId)->first();
        
        return response()->json(['formData' => json_decode($templateData->form_data)]);
    }
    public function generateResponseReport($id, $format)
    {
        $export = new FormResponseExport($id);
    
        // Get the template name
        $template = FormTemplate::findOrFail($id);
        $templateName = $template->template_name ?: "Template {$id}";
    
        // Choose format based on the user selection
        if ($format === 'pdf') {
            $pdf = PDF::loadView('reports.form_responses', [
                'data' => $export->collection(),
                'headings' => $export->headings(),
                'templateName' => $templateName, // Pass template name to the view
            ]);
    
            // Set the file name for the PDF format
            $fileName = Str::slug($templateName) . '_responses.pdf';
    
            return $pdf->download($fileName);
        } elseif ($format === 'excel') {
            // Set the file name for the Excel format
            $fileName = Str::slug($templateName) . '_responses.xlsx';
    
            return Excel::download($export, $fileName);
        } else {
            // Handle other formats or show an error
            return response()->json(['error' => 'Invalid format']);
        }
    }
    
}