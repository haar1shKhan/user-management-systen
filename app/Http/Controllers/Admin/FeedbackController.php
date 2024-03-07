<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Mail\FeedbackMail;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        return view('admin.feedback.index', ['page_title' => 'Feedback']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function send(Request $request)
    {
        $reqType = $request->input('reqType');
        $subject = $request->input('subject');
        $message = $request->input('topic');
        $attachment = "";

        if ($request->hasFile('file')) {
            $fileName = date('Y-m-d-H-s-i') . 'feedback.' . $request->file->extension();
            $attachment = $request->file('file')->storeAs('public/feedback', $fileName);
        }

        $data = [
            'subject' => $subject,
            'reqType' => $reqType,
            'message' => $message,
            'attachment' => $attachment,
        ];

        Mail::to('haarishkhan13@gmail.com')->send(new FeedbackMail($data));

        return redirect()->route('admin.feedback');
    }
}
