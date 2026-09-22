<?php

namespace Database\Seeders;

use App\Models\RoasStep;
use Illuminate\Database\Seeder;

class RoasStepSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'number' => 1,
                'title' => 'Review',
                'summary' => '13-step comprehensive review of ad tech, creative, account setups & business priorities',
                'icon_svg' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.6"/><path d="M20 20l-4.8-4.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
                'detail' => 'Before we touch a dollar of spend, we audit the account end to end. A few of the areas the 13-point audit covers:',
                'features' => [
                    'Account & campaign architecture',
                    'Ad tech and tracking health',
                    'Creative inventory and performance',
                    'Audience and targeting strategy',
                    'Attribution and measurement setup',
                    'Business priorities and margin targets',
                ],
            ],
            [
                'number' => 2,
                'title' => 'Operate',
                'summary' => 'Active Ads Management. Reviewed daily, optimized as necessary - ad units, audiences, copy, visuals, budgets, etc.',
                'icon_svg' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 12h4M16 12h4M12 4v4M12 16v4M6.3 6.3l2.8 2.8M14.9 14.9l2.8 2.8M17.7 6.3l-2.8 2.8M9.1 14.9l-2.8 2.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="12" r="3.2" stroke="currentColor" stroke-width="1.6"/></svg>',
                'detail' => 'Active management, not a monthly check-in. This is where the account is actually run:',
                'features' => [
                    'Daily budget and bid adjustments',
                    'Audience refresh and expansion',
                    'Creative rotation and copy testing',
                    'Sunsetting underperforming ad units',
                    'Cross-channel budget reallocation',
                    'Weekly performance reporting',
                ],
            ],
            [
                'number' => 3,
                'title' => 'Improve',
                'summary' => 'Kaizen. Continuous measurement, creative testing, attribution updates & planning',
                'icon_svg' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 16l5-5.5 3.5 3 6.5-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 6h4v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                'detail' => 'Kaizen — constant, incremental improvement that feeds straight back into the next Review:',
                'features' => [
                    'Creative testing cadence and learnings',
                    'Attribution and incrementality checks',
                    'Retrospective performance analysis',
                    'Forward budget forecasting',
                    'Quarterly strategy planning',
                    'Findings routed back into Review',
                ],
            ],
        ] as $i => $row) {
            $features = $row['features'];
            unset($row['features']);

            $step = RoasStep::create($row + ['sort_order' => $i + 1]);

            foreach ($features as $j => $text) {
                $step->features()->create(['text' => $text, 'sort_order' => $j + 1]);
            }
        }
    }
}
