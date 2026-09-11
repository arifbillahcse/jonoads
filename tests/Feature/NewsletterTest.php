<?php

namespace Tests\Feature;

use App\Mail\NewsletterConfirmation;
use App\Models\NewsletterSubscriber;
use App\Support\SpamGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'email' => 'reader@example.com',
            SpamGuard::HONEYPOT => '',
            SpamGuard::TIMESTAMP => Crypt::encryptString((string) (now()->getTimestamp() - 30)),
        ], $overrides);
    }

    public function test_signing_up_creates_a_pending_subscriber_and_sends_a_confirmation(): void
    {
        Mail::fake();

        $this->post(route('newsletter.subscribe'), $this->payload())
            ->assertRedirect()
            ->assertSessionHas('newsletter_status');

        $subscriber = NewsletterSubscriber::sole();
        $this->assertSame('pending', $subscriber->status);
        $this->assertNotNull($subscriber->confirmation_token);

        Mail::assertSent(NewsletterConfirmation::class);
    }

    public function test_the_address_is_normalised(): void
    {
        Mail::fake();

        $this->post(route('newsletter.subscribe'), $this->payload(['email' => '  Reader@Example.COM ']));

        $this->assertSame('reader@example.com', NewsletterSubscriber::sole()->email);
    }

    public function test_confirming_marks_the_subscriber_and_burns_the_token(): void
    {
        $subscriber = NewsletterSubscriber::factory()->create(['confirmation_token' => 'tok-123']);

        $this->get(route('newsletter.confirm', ['token' => 'tok-123']))->assertRedirect();

        $subscriber->refresh();
        $this->assertSame('confirmed', $subscriber->status);
        $this->assertNotNull($subscriber->confirmed_at);
        $this->assertNull($subscriber->confirmation_token, 'the link should only work once');
    }

    public function test_an_unknown_confirmation_token_is_rejected(): void
    {
        $this->get(route('newsletter.confirm', ['token' => 'nope']))
            ->assertRedirect()
            ->assertSessionHas('newsletter_status');

        $this->assertSame(0, NewsletterSubscriber::where('status', 'confirmed')->count());
    }

    public function test_resubscribing_a_confirmed_address_does_not_resend(): void
    {
        Mail::fake();
        NewsletterSubscriber::factory()->confirmed()->create(['email' => 'reader@example.com']);

        $this->post(route('newsletter.subscribe'), $this->payload());

        Mail::assertNothingSent();
        $this->assertSame(1, NewsletterSubscriber::count());
    }

    public function test_unsubscribe_requires_a_signed_link(): void
    {
        $subscriber = NewsletterSubscriber::factory()->confirmed()->create();

        // Unsigned: refused, so the link cannot be forged for someone else.
        $this->get('/newsletter/unsubscribe/' . $subscriber->id)->assertForbidden();
        $this->assertSame('confirmed', $subscriber->refresh()->status);

        $this->get($subscriber->unsubscribeUrl())->assertRedirect();
        $this->assertSame('unsubscribed', $subscriber->refresh()->status);
    }
}
