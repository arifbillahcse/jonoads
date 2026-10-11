<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded with the old Calendly link.
 * The client switched booking providers to their own widget (a
 * link.jonoads.com booking page, embeddable in the on-site popup).
 * SiteSettingSeeder has the right value for a fresh install; this
 * updates the existing row directly since re-running the seeder would
 * try to insert a duplicate key. Safe to run more than once.
 */
class FixBookingUrl extends Command
{
    protected $signature = 'fix:booking-url';

    protected $description = 'Set the live calendly_url setting to the client\'s new booking widget link';

    public function handle(): void
    {
        $updated = SiteSetting::where('key', 'calendly_url')->update([
            'value' => 'https://link.jonoads.com/widget/booking/LzPsfw3RJpY5xtgM7sKM',
        ]);

        cache()->forget(SiteSetting::CACHE_KEY);

        $this->info("calendly_url updated: {$updated} row(s).");
    }
}
