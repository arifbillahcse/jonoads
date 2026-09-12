<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\SmbContent;
use Illuminate\Database\Seeder;

class SmbContentSeeder extends Seeder
{
    public function run(): void
    {
        SmbContent::create([
            'eyebrow' => 'SMB program',
            'headline' => 'Enterprise media buying, sized for your market.',
            'intro' => 'The same buyers who run nine-figure budgets for billion-dollar brands, on a program built for a local and regional budget. One market, one team, and the same daily management the enterprise accounts get.',
            'industries_heading' => 'Built around how local demand actually works.',
            'approach_heading' => 'What a local budget usually buys, and what it buys here.',
            'cta_heading' => 'Let\'s look at your market.',
            'cta_body' => 'Tell us your service area and what you\'re spending now. We\'ll tell you what we\'d change first.',
        ]);

        foreach ([
            [
                'name' => 'HVAC',
                'note' => 'Seasonal demand, emergency intent',
            ],
            [
                'name' => 'Electrical',
                'note' => 'Service calls and project work',
            ],
            [
                'name' => 'Construction',
                'note' => 'Long consideration, high ticket',
            ],
            [
                'name' => 'Lawn Care',
                'note' => 'Recurring contracts, route density',
            ],
            [
                'name' => 'Interior Design',
                'note' => 'Portfolio-led, referral heavy',
            ],
            [
                'name' => 'Med Spas',
                'note' => 'Repeat treatment, local competition',
            ],
            [
                'name' => 'Pest Control',
                'note' => 'Urgent intent, subscription upsell',
            ],
            [
                'name' => 'Private Schools',
                'note' => 'Enrolment windows, parent targeting',
            ],
        ] as $i => $row) {
            Industry::create($row + ['sort_order' => $i + 1]);
        }
    }
}
