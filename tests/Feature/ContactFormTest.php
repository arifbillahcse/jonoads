<?php

namespace Tests\Feature;

use App\Mail\ContactLeadReceived;
use App\Models\ContactLead;
use App\Support\SpamGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /** A submission that looks like a person filling in the form. */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Dana Okafor',
            'email' => 'dana@example.com',
            'company' => 'Acme',
            'monthly_spend' => '$50k–$250k',
            'message' => 'We are spending on Meta and want a second opinion.',
            SpamGuard::HONEYPOT => '',
            SpamGuard::TIMESTAMP => Crypt::encryptString((string) (now()->getTimestamp() - 30)),
        ], $overrides);
    }

    public function test_a_valid_enquiry_is_stored_and_emailed(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), $this->payload())
            ->assertRedirect()
            ->assertSessionHas('contact_status');

        $lead = ContactLead::sole();
        $this->assertSame('dana@example.com', $lead->email);
        $this->assertSame('new', $lead->status);

        Mail::assertSent(ContactLeadReceived::class);
    }

    public function test_it_rejects_a_submission_with_a_filled_honeypot(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), $this->payload([SpamGuard::HONEYPOT => 'http://spam.example']))
            ->assertSessionHasErrors('message');

        $this->assertSame(0, ContactLead::count());
        Mail::assertNothingSent();
    }

    public function test_it_rejects_a_form_submitted_instantly(): void
    {
        $this->post(route('contact.store'), $this->payload([
            SpamGuard::TIMESTAMP => Crypt::encryptString((string) now()->getTimestamp()),
        ]))->assertSessionHasErrors('message');

        $this->assertSame(0, ContactLead::count());
    }

    public function test_it_requires_a_name_email_and_message(): void
    {
        $this->post(route('contact.store'), $this->payload([
            'name' => '', 'email' => 'not-an-email', 'message' => '',
        ]))->assertSessionHasErrors(['name', 'email', 'message']);
    }

    /** A mail outage must not lose the enquiry or show the sender an error. */
    public function test_the_lead_is_kept_even_if_the_notification_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('smtp down'));

        $this->post(route('contact.store'), $this->payload())
            ->assertRedirect()
            ->assertSessionHas('contact_status');

        $this->assertSame(1, ContactLead::count());
    }
}
