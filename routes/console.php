<?php

use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:prune-batches')->daily();

// A pending sign-up that was never confirmed is not a subscriber, and holding
// the address indefinitely serves no one.
Schedule::call(function () {
    NewsletterSubscriber::query()
        ->where('status', 'pending')
        ->where('created_at', '<', now()->subDays(30))
        ->delete();
})->daily()->name('prune-unconfirmed-subscribers');
