<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FileUpload;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = DB::table('users')->count();
        $form_inputs = DB::table('form_inputs')->count();    // Assuming you have a FormInput model
        $file_uploads = DB::table('file_uploads')->count();  // Assuming you have a FileUpload model
        $form_templates = DB::table('form_templates')->count();  // Assuming you have a form builder template model
        $ocr_result = DB::table('ocr_result')->count();
        //return view('home',compact('users','form_inputs','file_uploads','form_templates','ocr_result'));

        // Fetch file uploads data from the 'file_uploads' table
        $fileUploads = DB::table('file_uploads')->get();

        return view('home', compact('users', 'form_inputs', 'file_uploads', 'form_templates', 'ocr_result', 'fileUploads'));
    }
}
