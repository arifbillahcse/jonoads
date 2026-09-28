<?php

namespace App\Console\Commands;

use App\Models\RoasStep;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before the client's round-1
 * feedback rewrote the three ROAS Engine step summaries (the line shown
 * under Review/Operate/Improve on the homepage's circular diagram).
 * RoasStepSeeder already has the right text for a fresh install; this
 * updates the matching rows on an existing database in place — titles,
 * features and everything else are untouched. Safe to run more than once.
 */
class FixRoasStepSummaries extends Command
{
    protected $signature = 'fix:roas-step-summaries';

    protected $description = 'Update the ROAS Engine step summaries with the round-1 feedback copy';

    public function handle(): void
    {
        $updates = [
            'Review' => '13-step comprehensive review of ad tech, creative, account setups & business priorities',
            'Operate' => 'Active Ads Management. Reviewed daily, optimized as necessary - ad units, audiences, copy, visuals, budgets, etc.',
            'Improve' => 'Kaizen. Continuous measurement, creative testing, attribution updates & planning',
        ];

        $updated = 0;

        foreach ($updates as $title => $summary) {
            $updated += RoasStep::where('title', $title)->update(['summary' => $summary]);
        }

        cache()->forget(\App\Support\SiteContent::KEYS[0]);
        cache()->forget('site.roas_steps');

        $this->info("Roas step summaries updated: {$updated} rows.");
    }
}
