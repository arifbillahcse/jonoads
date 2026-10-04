<?php

namespace App\Console\Commands;

use App\Models\Stat;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before the homepage's stat
 * labels were brought to Title Case and had "Combined" dropped (per the
 * client's feedback on the home_hero and pedigree groups) - the other
 * pages' own stat strips (team_hero, contact_hero, engine_hero,
 * engine_proof) were never brought in line with that same change, so
 * they still read in sentence case. StatSeeder already has the right
 * labels for a fresh install; this updates the matching rows on an
 * existing database by their old label text. Safe to run more than
 * once - once updated, old => new no longer matches and later runs
 * change nothing.
 */
class FixOtherPageStatLabels extends Command
{
    protected $signature = 'fix:other-page-stat-labels';

    protected $description = 'Title-case the team/contact/ROAS Engine page stat labels, matching the homepage';

    public function handle(): void
    {
        $renames = [
            'Point audit in Review' => 'Point Audit In Review',
            'Media run through the Engine' => 'Media Run Through The Engine',
            'Years undefeated' => 'Years Undefeated',
            'Contests, zero losses' => 'Contests, Zero Losses',
            'Combined years at mega brands' => 'Years At Mega Brands',
            'Brands scaled' => 'Brands Scaled',
            'Billion-dollar brands' => 'Billion-Dollar Brands',
            'Access to your team' => 'Access To Your Team',
            'Offices, one team' => 'Offices, One Team',
            'Monthly budget scaled' => 'Monthly Budget Scaled',
            'ROAS lift in 4 months' => 'ROAS Lift In 4 Months',
            'To 3x ROAS for one client' => 'To 3x ROAS For One Client',
        ];

        $updated = 0;
        foreach ($renames as $old => $new) {
            $updated += Stat::where('label', $old)->update(['label' => $new]);
        }

        cache()->forget(\App\Support\SiteContent::KEYS[0]);

        $this->info("Stat labels updated: {$updated} row(s).");
    }
}
