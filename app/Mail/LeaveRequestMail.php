<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
        // "username" => auth()->user()->first_name.' '.auth()->user()->last_name,
        // 'leave_type' => $userEntitlement->policy->title,
        // 'start_date' => strtotime(date("d/m/Y", $startDate)),
        // 'end_date' => strtotime(date("d/m/Y", $endDate)),
        // 'reason' => $request->input("comment"),

    public $username;
    public $leave_type;
    public $start_date;
    public $end_date;
    public $days;
    public $date;
    public $reason;
    public $admin;
    public $status;

    public function __construct($data)
    {
        $this->username = $data['username'];
        $this->leave_type = $data['leave_type'];
        $this->start_date = $data['start_date'];
        $this->end_date = $data['end_date'];
        $this->days = $data['days'];
        $this->date = $data['date'] ?? null;
        $this->reason = $data['reason'];
        $this->admin = ucfirst(config('settings.store_owner'));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New leave request recieved from ".ucfirst($this->username),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.requestLeaveMail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
