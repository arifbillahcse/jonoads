<?php

namespace Database\Seeders;

use App\Models\EngagementModel;
use Illuminate\Database\Seeder;

class EngagementModelSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'title' => 'Media Management',
                'features' => [
                    'Omni-channel media buying — planning, daily optimization',
                    'Performance reporting across media and creative',
                    'Creative strategy and production with your team',
                    'Weekly meetings, historical review, forward planning',
                ],
            ],
            [
                'title' => 'Team Augment',
                'features' => [
                    'Fixed term, side-by-side training',
                    'Knowledge exchange on media, creative, attribution',
                    'Enhanced reporting and stakeholder management',
                    'Creative development support',
                ],
            ],
            [
                'title' => 'Media Audit',
                'features' => [
                    '360-degree review of every paid media channel',
                    'Ad tech, account architecture, creative, attribution',
                    'Findings plus a plan of actionable next steps',
                ],
            ],
        ] as $i => $row) {
            $features = $row['features'];
            unset($row['features']);

            $model = EngagementModel::create($row + ['sort_order' => $i + 1]);

            foreach ($features as $j => $text) {
                $model->features()->create(['text' => $text, 'sort_order' => $j + 1]);
            }
        }
    }
}
