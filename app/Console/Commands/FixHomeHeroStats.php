<?php

namespace App\Console\Commands;

use App\Models\Stat;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before the client's round-1
 * feedback changed the homepage hero strip, and again before a later
 * reorder request (Brands Scaled, then Billion-Dollar Brands, then
 * 9-Figure Brands last). StatSeeder already has the right rows for a
 * fresh install; this replaces the home_hero group's rows on an
 * existing database the same way, without duplicating them. Safe to
 * run more than once — it clears the group first each time.
 */
class FixHomeHeroStats extends Command
{
    protected $signature = 'fix:home-hero-stats';

    protected $description = 'Replace the homepage hero stat strip with the round-1 feedback values';

    public function handle(): void
    {
        Stat::where('group', 'home_hero')->forceDelete();

        foreach ([
            ['label' => 'Media Managed', 'value' => 250.0, 'prefix' => '$', 'suffix' => 'M+', 'sort_order' => 1],
            ['label' => 'Revenue Generated', 'value' => 750.0, 'prefix' => '$', 'suffix' => 'M+', 'sort_order' => 2],
            ['label' => 'Brands Scaled', 'value' => 40.0, 'prefix' => '', 'suffix' => '+', 'sort_order' => 3],
            ['label' => 'Billion-Dollar Brands', 'value' => 7.0, 'prefix' => '', 'suffix' => '', 'sort_order' => 4],
            ['label' => '9-Figure Brands', 'value' => 15.0, 'prefix' => '', 'suffix' => '+', 'sort_order' => 5],
        ] as $row) {
            Stat::create($row + [
                'group' => 'home_hero',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'is_published' => true,
            ]);
        }

        cache()->forget(\App\Support\SiteContent::KEYS[0]);

        $this->info('Home hero stats replaced: ' . Stat::where('group', 'home_hero')->count() . ' rows.');
    }
}
