<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class FeedbackController extends Controller
{
    public function feedbackIndex()
    {
        $feedback = Feedback::all(); // You can modify this to filter by user or status
        return view('feedback/index', compact('feedback'));
    }

    public function feedbackCreate()
    {
        return view('feedback/create');
    }

    public function feedbackStore(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Feedback::create([
            'user_id' => auth()->id(), // Assuming you're using authentication
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        Toastr::success('Feedback submitted successfully', 'Success'); // Add a success message
        return redirect()->back();
    }

    /** delete record */
    public function feedbackDelete(Request $request)
    {
        try {
            Feedback::destroy($request->id);
            Toastr::success('Data has been deleted successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Data delete fail :)','Error');
            return redirect()->back();
        }
    }
}