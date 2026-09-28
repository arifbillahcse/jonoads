<?php

namespace App\Console\Commands;

use App\Models\SmbContent;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before section titles across the
 * site were changed to Title Case. Every other section title lives in Blade
 * views and updates with a normal deploy; the SMB page's headings are the
 * only ones stored in the database (SmbContentSeeder), so they need this
 * to catch up the same way the stats and ROAS summaries did. Safe to run
 * more than once — it only touches the single existing row.
 */
class FixSectionTitleCasing extends Command
{
    protected $signature = 'fix:smb-headings';

    protected $description = 'Title Case the SMB page headings stored in the database';

    public function handle(): void
    {
        $updated = SmbContent::query()->update([
            'headline' => 'Enterprise Media Buying, Sized For Your Market.',
            'industries_heading' => 'Built Around How Local Demand Actually Works.',
            'approach_heading' => 'What A Local Budget Usually Buys, And What It Buys Here.',
            'cta_heading' => "Let's Look At Your Market.",
        ]);

        cache()->forget('site.smb');

        $this->info("SMB headings updated: {$updated} row(s).");
    }
}
