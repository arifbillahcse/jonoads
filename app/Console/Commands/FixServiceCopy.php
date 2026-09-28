<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before the client's round-1
 * feedback rewrote the services list. `summary` (shown on the homepage)
 * was already right; `detail` (shown on the services page) still had the
 * older, longer copy and took priority over `summary` there, so the new
 * copy never actually appeared on that page. Nulling `detail` lets the
 * page fall back to the same `summary` text everywhere. Safe to run more
 * than once — it always sets the same values.
 */
class FixServiceCopy extends Command
{
    protected $signature = 'fix:service-copy';

    protected $description = 'Sync the live services table with the round-1 feedback copy';

    public function handle(): void
    {
        $updates = [
            'Digital Advertising' => [
                'summary' => 'Media planning, optimization and attribution across Meta, Google, TikTok, X, CTV, podcasts, Reddit, etc. Executed by pros who\'ve managed 9-figures in ad spend.',
                'sort_order' => 1,
            ],
            'CMO Advisory' => [
                'summary' => 'Go-to-market plans (GTM), organizational alignment and leadership, omni-channel and full-funnel customer acquisition strategy. Best practices used over 200 times to future-proof growth programs at billion-dollar brands.',
                'sort_order' => 2,
            ],
            'Creative Services' => [
                'summary' => 'High-caliber creative to fuel consistent growth. Integrate with client internal teams or utilize ours. Brief writing, concepting, project management and optimization pipeline.',
                'sort_order' => 3,
            ],
            'CRM Strategy' => [
                'summary' => 'Email and SMS optimization, database monetization, customer journey planning.',
                'sort_order' => 4,
            ],
        ];

        $updated = 0;

        foreach ($updates as $title => $data) {
            $updated += Service::where('title', $title)->update($data + ['detail' => null]);
        }

        cache()->forget('site.services');

        $this->info("Services updated: {$updated} rows.");
    }
}
