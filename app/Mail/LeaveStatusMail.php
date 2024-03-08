<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $username;
    public $status;
    public $leave_type;
    public $approved_by;
    public $days;
    public $start;
    public $end;
    public $reason;

    public function __construct($data)
    {
        //
        $this->username = $data['reciever_name'];
        $this->status = $data['status'];
        $this->leave_type = $data['leave_type'];
        $this->approved_by = $data['username'];
        $this->duration = $data['duration'];
        $this->start = $data['from'];
        $this->end = $data['to'];
        $this->reason = $data['reason'] ?? null;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Status Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.leaveStatusMail',
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
