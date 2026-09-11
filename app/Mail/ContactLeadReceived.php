<?php

namespace App\Mail;

use App\Models\ContactLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactLeadReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactLead $lead) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New enquiry from ' . $this->lead->name,
            // Replying to the notification should reach the prospect directly.
            replyTo: [$this->lead->email],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.contact-lead-received');
    }
}
