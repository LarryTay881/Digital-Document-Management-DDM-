<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\WebcamController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\OcrController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TextErrorPredictorContoller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** set active sidebar */
Auth::routes();

Route::get('/', function () {
    return view('auth/login');
})->name('/');

Route::get('/index', function () {
    return view('google2fa.index');
})->name('index');

Route::get('/complete-registration',[RegisterController::class,'completeRegistration'])->name('complete.registration');
Route::middleware(['auth', 'verified', '2fa'])->group(function(){
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard'); 
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/2fa',function(){
        return redirect(route('home'));
    })->name('2fa');
    
});

Route::get('form/link/{id}', [FormBuilderController::class, 'formLink'])->name('form/link');
Route::post('form/submit/response', [FormBuilderController::class, 'formSubmit'])->name('form/submit/response');

Route::group(["middleware" => "auth"], function () {
    // ----------------------------- main dashboard -----------------------------//
    Route::controller(HomeController::class)->group(function () {
        Route::get('form/input', 'index')->name('form/input');
    });
    // ---------------------------------- form ----------------------------------//
    Route::controller(FormController::class)->group(function () {
        Route::get('form/input/page', 'formIndex')->name('form/input/page');
        Route::post('form/input/save', 'formSaveRecord')->name('form/input/save');
        Route::get('form/page/view', 'formView')->name('form/page/view');
        Route::get('form/input/edit/{id}', 'formInputEdit');
        Route::post('form/input/update', 'formUpdateRecord')->name('form/input/update');
        Route::post('form/input/delete', 'formDelete')->name('form/input/delete');
        Route::get('form/update/page', 'formUpdateIndex')->name('form/update/page');

        Route::post('form/upload/file', 'formFileUpdate')->name('form/upload/file'); // file upload
        Route::get('view/upload/file', 'formFileView')->name('view/upload/file'); // file view
        Route::get('download/file/{file_name}', 'fileDownload'); // file download
        Route::post('download/file/delete', 'fileDelete')->name('download/file/delete'); // file delete

        Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
        Route::get('form/webcam/capture', [WebcamController::class, 'index']);
        Route::post('form/webcam/capture', [WebcamController::class, 'store'])->name('form/webcam/capture');
        Route::post('form/ocr/result', [OcrResultController::class, 'upload'])->name('form/ocr/result');

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        // ---------------------------- Form Builder ----------------------------//
        Route::post('form/save/template', [FormBuilderController::class,'saveData'])->name('form/save/template');
        Route::post('form/update/template', [FormBuilderController::class,'updateTemplate'])->name('form/update/template');
        Route::get('form/view/template', [FormBuilderController::class,'templateView'])->name('form/view/template');
        Route::get('form/edit/template/{id}', [FormBuilderController::class,'templateEdit'])->name('form/edit/template');
        Route::get('form/template/{id}', [FormBuilderController::class,'serveForm'])->name('form/template');
        Route::post('form/delete', [FormBuilderController::class, 'deleteTemplate'])->name('form/delete');
        Route::post('form/send', [FormBuilderController::class, 'sendForm'])->name('form/send');
        Route::get('form/list', [FormBuilderController::class,'formList'])->name('form/list');
        Route::get('form/response/{id}', [FormBuilderController::class,'formResponse'])->name('form/response');
        Route::post('save/ocr/template', [FormBuilderController::class, 'ocrTemplate'])->name('save/ocr/template');
        Route::post('save/ocr/response', [FormBuilderController::class, 'ocrResponse'])->name('save/ocr/response');
        Route::get('get/template/list', [FormBuilderController::class, 'getTemplateList'])->name('get/template/list');
        Route::get('get/template/fields', [FormBuilderController::class, 'getTemplateFields'])->name('get/template/fields');
        Route::get('form/builder', function () {
            return view('form.form-builder');
        })->name('form/builder');
        function set_active($route) {
            if (is_array($route)) {
                return in_array(Request::path(), $route) ? 'active' : '';
            }
            return Request::path() == $route ? 'active' : '';
        }
        Route::get('/generate-report/{format?}', [FormController::class, 'generateEmployeeReport'])->name('generate.report');
        Route::get('/generate-fileUpload-report/{format?}', [FormController::class, 'generateFileUploadReport'])->name('generate.fileUpload.report');
        Route::get('form/list/{format?}', [FormController::class,'generateFormResponseReport'])->name('form/list');
        Route::get('form/response/{id}/{format?}', [FormBuilderController::class,'generateResponseReport'])->name('generate.form.response');
    });

    // ---------------------------------- OCR ----------------------------------//
    Route::controller(OcrController::class)->group(function () {
        Route::get('ocr/recognize', 'index')->name('ocr/recognize');
        Route::get('ocr/show/image/{id}', 'showImage')->name('ocr/show/image');
        Route::post('ocr/saveresult', 'saveResult')->name('ocr/saveresult');

    });
    // ---------------------------- User Management ----------------------------//
    Route::get('userManagement', [App\Http\Controllers\UserManagementController::class, 'index'])->middleware('auth')->name('userManagement');
    Route::get('user/add/new', [App\Http\Controllers\UserManagementController::class, 'addNewUser'])->middleware('auth')->name('user/add/new');
    Route::post('user/add/save', [App\Http\Controllers\UserManagementController::class, 'addNewUserSave'])->name('user/add/save');
    Route::get('view/detail/{id}', [App\Http\Controllers\UserManagementController::class, 'viewDetail'])->middleware('auth');
    Route::post('update', [App\Http\Controllers\UserManagementController::class, 'update'])->name('update');
    Route::get('delete_user/{id}', [App\Http\Controllers\UserManagementController::class, 'delete'])->middleware('auth');
    Route::get('/add-new-user', [App\Http\Controllers\UserManagementController::class, 'addNewUser'])->name('addNewUser');

    Route::get('change/password', [App\Http\Controllers\UserManagementController::class, 'changePasswordView'])->middleware('auth')->name('change/password');
    Route::post('change/password/db', [App\Http\Controllers\UserManagementController::class, 'changePasswordDB'])->name('change/password/db');

    Route::get('/profile/edit', [App\Http\Controllers\UserController::class, 'editProfile'])->middleware('auth')->name('editProfile');
    Route::post('/profile/update', [App\Http\Controllers\UserController::class, 'updateProfile'])->middleware('auth')->name('updateProfile');
    Route::get('show/avatar/{avatar}', [App\Http\Controllers\UserController::class, 'showAvatar'])->name('show/avatar');

    // ------------------------------- Feedback --------------------------------//
    Route::get('/feedback', [App\Http\Controllers\FeedbackController::class, 'feedbackIndex'])->name('feedback/index');
    Route::get('/feedback/create', [App\Http\Controllers\FeedbackController::class, 'feedbackCreate'])->name('feedback/create');
    Route::post('/feedback', [App\Http\Controllers\FeedbackController::class, 'feedbackStore'])->name('feedback/store');
    Route::delete('feedback/delete', [App\Http\Controllers\FeedbackController::class, 'feedbackDelete'])->name('feedback/delete');
});
