<?php

namespace App\Console\Commands;

use App\Models\BrandLogo;
use Illuminate\Console\Command;

/**
 * One-off command for removing a brand from the marquee ticker on a live
 * deployment, since brand logos are admin-managed content rather than a
 * seeder — there's no "re-seed" step that would otherwise drop a row the
 * client no longer wants shown (e.g. "Verdante", which they asked not to
 * use at all).
 */
class RemoveBrandLogo extends Command
{
    protected $signature = 'fix:remove-brand-logo {name}';

    protected $description = 'Force-delete a brand logo by name (case-insensitive partial match)';

    public function handle(): void
    {
        $name = $this->argument('name');

        $matches = BrandLogo::where('name', 'like', '%' . $name . '%')->get();

        if ($matches->isEmpty()) {
            $this->warn("No brand logo found matching \"{$name}\".");

            return;
        }

        foreach ($matches as $match) {
            $this->info("Removing: {$match->name}");
            $match->forceDelete();
        }

        $this->info('Done.');
    }
}
