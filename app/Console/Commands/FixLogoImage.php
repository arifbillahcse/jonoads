<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment already seeded with an empty
 * logo_image setting. Points it at the cursive wordmark the client
 * supplied (a white mark on a transparent background, meant for the
 * site's own transparent/dark header rather than a white page). Safe to
 * run more than once.
 */
class FixLogoImage extends Command
{
    protected $signature = 'fix:logo-image';

    protected $description = 'Point the live logo_image setting at the cursive logo file';

    public function handle(): void
    {
        $updated = SiteSetting::where('key', 'logo_image')->update([
            'value' => 'placeholders/logo-cursive.webp',
        ]);

        cache()->forget(SiteSetting::CACHE_KEY);

        $this->info("logo_image updated: {$updated} row(s).");
    }
}
