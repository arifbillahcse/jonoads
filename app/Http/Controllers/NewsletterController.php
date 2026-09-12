<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriberRequest;
use App\Mail\NewsletterConfirmation;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(StoreSubscriberRequest $request): RedirectResponse
    {
        $email = strtolower(trim($request->validated('email')));

        $subscriber = NewsletterSubscriber::firstOrNew(['email' => $email]);

        // Someone already confirmed gets a reassuring message rather than a
        // second confirmation email.
        if ($subscriber->exists && $subscriber->status === 'confirmed') {
            return $this->back("You're already subscribed.");
        }

        $subscriber->fill([
            'status' => 'pending',
            'confirmation_token' => Str::random(64),
            'unsubscribed_at' => null,
            'source_page' => $request->input('source_page') ?: url()->previous(),
            'ip_address' => $request->ip(),
        ])->save();

        try {
            Mail::to($subscriber->email)->send(new NewsletterConfirmation(
                $subscriber,
                URL::route('newsletter.confirm', ['token' => $subscriber->confirmation_token]),
            ));
        } catch (\Throwable $e) {
            Log::error('Newsletter confirmation email failed', [
                'subscriber_id' => $subscriber->id,
                'error' => $e->getMessage(),
            ]);

            return $this->back('We saved your address but could not send the confirmation email. Please try again shortly.');
        }

        return $this->back('Almost there — check your inbox to confirm.');
    }

    public function confirm(string $token): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::where('confirmation_token', $token)->first();

        if (! $subscriber) {
            return $this->back('That confirmation link is no longer valid.');
        }

        $subscriber->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
            // Single use: the link stops working once it has been followed.
            'confirmation_token' => null,
        ]);

        return $this->back("You're subscribed. Thanks for joining.");
    }

    public function unsubscribe(NewsletterSubscriber $subscriber): RedirectResponse
    {
        $subscriber->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
            'confirmation_token' => null,
        ]);

        return $this->back("You've been unsubscribed.");
    }

    private function back(string $message): RedirectResponse
    {
        return redirect()
            ->route('contact')
            ->with('newsletter_status', $message)
            ->withFragment('newsletter');
    }
}
