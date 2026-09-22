<?php

namespace Database\Seeders;

use App\Models\ComparisonCheck;
use App\Models\ComparisonMetric;
use Illuminate\Database\Seeder;

class ComparisonSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'title' => 'Outperformed client\'s previous team',
                'baseline_label' => 'Avg agency',
                'baseline_value' => 33.0,
                'jono_label' => 'Jono',
                'jono_value' => 100.0,
                'suffix' => '%',
            ],
            [
                'title' => 'Client ROAS we increased 25%+',
                'baseline_label' => 'Avg agency',
                'baseline_value' => 25.0,
                'jono_label' => 'Jono',
                'jono_value' => 99.0,
                'suffix' => '%',
            ],
            [
                'title' => 'Career ad spend managed by your buyer ($M)',
                'baseline_label' => 'Avg agency',
                'baseline_value' => 2.0,
                'jono_label' => 'Jono',
                'jono_value' => 250.0,
                'suffix' => 'M',
            ],
            [
                'title' => 'Media buyer years experience',
                'baseline_label' => 'Avg agency',
                'baseline_value' => 4.0,
                'jono_label' => 'Jono',
                'jono_value' => 28.0,
                'suffix' => '',
            ],
        ] as $i => $row) {
            ComparisonMetric::create($row + ['sort_order' => $i + 1]);
        }

        // The checklist is a two-column CSS grid, which fills row by row —
        // so this order reads left, right, left, right down the page. The
        // client asked for 24/7 access on the left and A-list partner network
        // on the right, which is why those two swap sides here.
        foreach ([
            'Only world-class talent',          // left, top
            '10X the avg team experience',      // right, top
            '24/7 on-demand access',            // left, middle
            'A-list partner network',           // right, middle
            'All-inclusive pricing model',      // left, bottom
            'Transparency is standard',         // right, bottom
        ] as $i => $text) {
            ComparisonCheck::create(['text' => $text, 'sort_order' => $i + 1]);
        }
    }
}
