<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Imports the copy that used to be hardcoded in the static HTML build.
     * Safe to re-run from scratch with `php artisan migrate:fresh --seed`.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SiteSettingSeeder::class,
            StatSeeder::class,
            BrandLogoSeeder::class,
            ServiceSeeder::class,
            EngagementModelSeeder::class,
            RoasStepSeeder::class,
            CaseStudySeeder::class,
            TestimonialSeeder::class,
            ComparisonSeeder::class,
            TeamMemberSeeder::class,
            PartnerSeeder::class,
            LocationSeeder::class,
            SmbContentSeeder::class,
        ]);
    }
}
