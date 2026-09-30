<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment already seeded before the client sent
 * their real Calendly link. SiteSettingSeeder has the right value for a
 * fresh install; this updates the existing row directly since re-running
 * SiteSettingSeeder would try to insert a duplicate key. Safe to run more
 * than once.
 */
class FixCalendlyUrl extends Command
{
    protected $signature = 'fix:calendly-url';

    protected $description = 'Set the live calendly_url setting to the client-supplied booking link';

    public function handle(): void
    {
        $updated = SiteSetting::where('key', 'calendly_url')->update([
            'value' => 'https://calendly.com/d/d2mc-3p7-qjh/digital-ads-strategy-call-w-jono-ads',
        ]);

        cache()->forget(SiteSetting::CACHE_KEY);

        $this->info("calendly_url updated: {$updated} row(s).");
    }
}
