<?php

namespace App\Console\Commands;

use App\Models\Stat;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before the client's round-1
 * feedback changed the pedigree strip, and again before a v2 round
 * dropped "Combined" from the years-at-mega-brands label and added "+"
 * to the ads-launched and creative-spend figures. StatSeeder already
 * has the right rows for a fresh install; this replaces the pedigree
 * group's rows on an existing database the same way, without
 * duplicating them. Safe to run more than once — it clears the group
 * first each time.
 */
class FixPedigreeStats extends Command
{
    protected $signature = 'fix:pedigree-stats';

    protected $description = 'Replace the pedigree stat strip with the round-1 feedback values';

    public function handle(): void
    {
        Stat::where('group', 'pedigree')->forceDelete();

        foreach ([
            ['label' => 'Media Managed', 'value' => 250.0, 'prefix' => '$', 'suffix' => 'M', 'sort_order' => 1],
            ['label' => 'Revenue Generated', 'value' => 750.0, 'prefix' => '$', 'suffix' => 'M+', 'sort_order' => 2],
            ['label' => 'Years At Mega Brands', 'value' => 100.0, 'prefix' => '', 'suffix' => '+', 'sort_order' => 3],
            ['label' => 'Unique Ads Launched', 'value' => 150000.0, 'prefix' => '', 'suffix' => '+', 'sort_order' => 4],
            ['label' => 'Creative Testing Spend', 'value' => 10.0, 'prefix' => '$', 'suffix' => 'M+', 'sort_order' => 5],
            ['label' => "Outperformed Client's Prior Team", 'value' => 100.0, 'prefix' => '', 'suffix' => '%', 'sort_order' => 6],
        ] as $row) {
            Stat::create($row + [
                'group' => 'pedigree',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'is_published' => true,
            ]);
        }

        cache()->forget(\App\Support\SiteContent::KEYS[0]);

        $this->info('Pedigree stats replaced: ' . Stat::where('group', 'pedigree')->count() . ' rows.');
    }
}
