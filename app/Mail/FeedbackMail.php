<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $slot;
    public $reqType;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        //
        $this->subject = $data['subject'];
        $this->slot = $data['message'];
        $this->reqType = $data['reqType'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New '.$this->reqType.' - '.$this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.feedbackMail',
        );
    }

    /**
     * Get the attachments for  the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Assuming $this->mailData['attachments'] is an array containing 'path' and 'name'.
        return [
            // Attachment::fromStorage('/path/to/file')
            // ->as('name.pdf')
            // ->withMime('application/pdf'),
        ];
    }
}
