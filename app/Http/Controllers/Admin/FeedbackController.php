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
    public function index()
    {
        //
        $page_title = 'Feedback';
        $data['page_title'] = 'Feedback';
        return view('admin.feedback.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    // Validate the incoming request data if needed

    $reqType = $request->input('requestType');
    $subject = $request->input('address');
    $chooseFile = $request->file('chooseFile');
    $message = $request->input('topic');

    // Check if a file is provided
    // if ($chooseFile) {
    //     // Store the file in the 'attachments' directory
    //     $path = $chooseFile->store('attachments');
    //     $attachmentData = [
    //         'path' => $path,
    //         'name' => $chooseFile->getClientOriginalName(),
    //     ];
    // } else {
    //     $attachmentData = null; // No attachment provided
    // }

    $data = [
        'subject' => $subject,
        'reqType' => $reqType,
        'message' => $message,
        // 'attachments' => $attachmentData,
    ];

    // Send email with attachment
    Mail::to('haarishkhan13@gmail.com')->send(new FeedbackMail($data));

    // Optionally, you can check if the email was sent successfully
    // if (count(Mail::failures()) > 0) {
    //     return response()->json(['message' => 'Failed to send email'], 500);
    // }

    // Return a success response
    // return response()->json(['message' => 'Email sent successfully']);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
