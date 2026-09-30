<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment already seeded with the old
 * hero_image path (placeholders/hero-placeholder.jpg). The client
 * supplied a second, different skyline photo as a .webp file — rather
 * than convert it (no image tooling available in this environment),
 * it ships as .webp, so the stored setting path needs to point at the
 * new filename. Safe to run more than once.
 */
class FixHeroImagePath extends Command
{
    protected $signature = 'fix:hero-image-path';

    protected $description = 'Point the live hero_image setting at the new .webp placeholder file';

    public function handle(): void
    {
        $updated = SiteSetting::where('key', 'hero_image')->update([
            'value' => 'placeholders/hero-placeholder.webp',
        ]);

        cache()->forget(SiteSetting::CACHE_KEY);

        $this->info("hero_image updated: {$updated} row(s).");
    }
}
