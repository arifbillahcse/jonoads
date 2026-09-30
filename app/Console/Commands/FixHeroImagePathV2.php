<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment already seeded with the old
 * hero_image path. Something in front of Apache (Cloudflare, LiteSpeed
 * Cache, or similar) kept serving a stale cached response for
 * placeholders/hero-placeholder.webp even with a cache-busting query
 * string and a confirmed-correct file on disk, so the file was renamed
 * to a URL no cache layer has seen before rather than fighting an
 * external cache this environment has no access to purge. Safe to run
 * more than once.
 */
class FixHeroImagePathV2 extends Command
{
    protected $signature = 'fix:hero-image-path-v2';

    protected $description = 'Point the live hero_image setting at the renamed hero-miami-v2.webp file';

    public function handle(): void
    {
        $updated = SiteSetting::where('key', 'hero_image')->update([
            'value' => 'placeholders/hero-miami-v2.webp',
        ]);

        cache()->forget(SiteSetting::CACHE_KEY);

        $this->info("hero_image updated: {$updated} row(s).");
    }
}
