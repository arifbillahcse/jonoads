<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment already seeded with the
 * link.jonoads.com redirect URL. The booking widget is now wired up via
 * Calendly's own popup embed, which needs the real Calendly link rather
 * than a redirect it can't resolve. Safe to run more than once.
 */
class FixCalendlyUrlV2 extends Command
{
    protected $signature = 'fix:calendly-url-v2';

    protected $description = 'Point the live calendly_url setting at the real Calendly booking link';

    public function handle(): void
    {
        SiteSetting::updateOrCreate(
            ['key' => 'calendly_url'],
            [
                'value' => 'https://calendly.com/d/d2mc-3p7-qjh/digital-ads-strategy-call-w-jono-ads',
                'group' => 'links',
                'label' => 'Calendly booking link',
                'type' => 'url',
            ],
        );

        cache()->forget(SiteSetting::CACHE_KEY);

        $this->info('calendly_url set.');
    }
}
