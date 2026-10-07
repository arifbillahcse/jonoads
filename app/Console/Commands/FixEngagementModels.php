<?php

namespace App\Console\Commands;

use App\Models\EngagementModel;
use Illuminate\Console\Command;

/**
 * One-off fix for a live deployment seeded before the client renamed the
 * "how we work together" models and rewrote their bullets: Media
 * Management -> Digital Advertising, Team Augment -> CMO Advisory & GTM
 * (down to 3 bullets from 4), Media Audit -> Advertising Audit.
 * EngagementModelSeeder already has the right rows for a fresh install;
 * this replaces the three models and their features on an existing
 * database the same way, without duplicating them. Safe to run more
 * than once — it clears the table first each time.
 */
class FixEngagementModels extends Command
{
    protected $signature = 'fix:engagement-models';

    protected $description = 'Replace the "how we work together" models with the latest feedback content';

    public function handle(): void
    {
        EngagementModel::query()->forceDelete();

        foreach ([
            [
                'title' => 'Digital Advertising',
                'features' => [
                    'Meta, Google, TikTok, Reddit, X, Pinterest, CTV, Pods',
                    'Media strategy, Active Ads Management, omni-channel attribution',
                    'Creative strategy, production, client team embed',
                    'Weekly performance meetings and forecasting',
                ],
            ],
            [
                'title' => 'CMO Advisory & GTM',
                'features' => [
                    'Omni-channel marketing planning',
                    'Go-to-market strategy',
                    'Organizational alignment',
                ],
            ],
            [
                'title' => 'Advertising Audit',
                'features' => [
                    '360-degree review of every paid media channel',
                    'Ad tech, account architecture, creative, attribution',
                    'Insights & actionable next steps',
                ],
            ],
        ] as $i => $row) {
            $features = $row['features'];
            unset($row['features']);

            $model = EngagementModel::create($row + [
                'sort_order' => $i + 1,
                'is_published' => true,
            ]);

            foreach ($features as $j => $text) {
                $model->features()->create(['text' => $text, 'sort_order' => $j + 1]);
            }
        }

        $this->info('Engagement models replaced: ' . EngagementModel::count() . ' rows.');
    }
}
