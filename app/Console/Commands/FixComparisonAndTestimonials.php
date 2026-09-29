<?php

namespace App\Console\Commands;

use App\Models\ComparisonCheck;
use App\Models\ComparisonMetric;
use App\Models\Testimonial;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before the client's round-1
 * feedback rewrote the comparison section (items 22-26) and the
 * testimonial band (items 27-28, three quotes only — the original
 * "Lens & Eyewear Client" quote is dropped, not kept alongside them).
 * ComparisonSeeder and TestimonialSeeder already have the right rows for
 * a fresh install; this replaces them on an existing database the same
 * way the earlier fix commands did. Safe to run more than once — it
 * clears each table first.
 */
class FixComparisonAndTestimonials extends Command
{
    protected $signature = 'fix:comparison-testimonials';

    protected $description = 'Replace the comparison section and testimonials with the round-1 feedback content';

    public function handle(): void
    {
        ComparisonMetric::query()->forceDelete();
        ComparisonCheck::query()->delete();
        Testimonial::query()->forceDelete();

        foreach ([
            ['title' => 'Outperformed client\'s previous team', 'baseline_value' => 33.0, 'jono_value' => 100.0, 'suffix' => '%'],
            ['title' => 'Client ROAS we increased 25%+', 'baseline_value' => 25.0, 'jono_value' => 99.0, 'suffix' => '%'],
            ['title' => 'Career ad spend managed by your buyer ($M)', 'baseline_value' => 2.0, 'jono_value' => 250.0, 'suffix' => 'M'],
            ['title' => 'Media buyer years experience', 'baseline_value' => 4.0, 'jono_value' => 28.0, 'suffix' => ''],
        ] as $i => $row) {
            ComparisonMetric::create($row + [
                'baseline_label' => 'Avg agency',
                'jono_label' => 'Jono',
                'sort_order' => $i + 1,
                'is_published' => true,
            ]);
        }

        foreach ([
            'Only world-class talent',
            '10X the avg team experience',
            '24/7 on-demand access',
            'A-list partner network',
            'All-inclusive pricing model',
            'Transparency is standard',
        ] as $i => $text) {
            ComparisonCheck::create(['text' => $text, 'sort_order' => $i + 1, 'is_published' => true]);
        }

        foreach ([
            [
                'quote' => 'Big fan. They have integrity, fantastic team. Worked with them at small and large brands.',
                'attribution' => 'Client Chief Digital Officer',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'quote' => 'Highly recommend. Joseph and his team are the real deal. Hired them at several of my companies.',
                'attribution' => 'Digital Marketing Director, Global Mobile Tech Brand',
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'quote' => 'Strongly recommend. Established stability and achieved ROAS goal fast. Reduced internal workload.',
                'attribution' => 'President, Global Fitness App & Consumer Wearables',
                'is_featured' => false,
                'sort_order' => 3,
            ],
        ] as $row) {
            Testimonial::create($row + ['is_published' => true]);
        }

        cache()->forget('site.comparison_metrics');
        cache()->forget('site.comparison_checks');
        cache()->forget('site.testimonials');

        $this->info(sprintf(
            'Replaced: %d comparison metrics, %d checks, %d testimonials.',
            ComparisonMetric::count(),
            ComparisonCheck::count(),
            Testimonial::count(),
        ));
    }
}
