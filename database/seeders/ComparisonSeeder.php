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
                'title' => 'Clients whose ROAS we increased 25%+',
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
                'title' => 'Years experience of your media buyer',
                'baseline_label' => 'Avg agency',
                'baseline_value' => 4.0,
                'jono_label' => 'Jono',
                'jono_value' => 28.0,
                'suffix' => '',
            ],
        ] as $i => $row) {
            ComparisonMetric::create($row + ['sort_order' => $i + 1]);
        }

        foreach ([
            'Only world-class talent',
            '10x the experience of a typical agency team',
            'A-list partner network',
            'Transparency is our standard',
            'All-inclusive pricing — you win, we win',
            '24/7 access',
        ] as $i => $text) {
            ComparisonCheck::create(['text' => $text, 'sort_order' => $i + 1]);
        }
    }
}
