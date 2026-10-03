<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment already seeded with the previous
 * hero_image (the v2 Miami day skyline). The client sent a new night
 * skyline shot they preferred, so this points hero_image at the
 * renamed file (a distinct filename, following the v2 fix's approach,
 * so no edge/CDN cache can confuse it with the old one). Safe to run
 * more than once.
 */
class FixHeroImagePathV3 extends Command
{
    protected $signature = 'fix:hero-image-path-v3';

    protected $description = 'Point the live hero_image setting at the new Miami night skyline photo';

    public function handle(): void
    {
        $updated = SiteSetting::where('key', 'hero_image')->update([
            'value' => 'placeholders/hero-miami-night.jpg',
        ]);

        cache()->forget(SiteSetting::CACHE_KEY);

        $this->info("hero_image updated: {$updated} row(s).");
    }
}
