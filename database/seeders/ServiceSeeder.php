<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'number' => '01',
                'title' => 'Digital Advertising',
                'summary' => 'Media planning, optimization, and attribution across Meta, Google, TikTok, X, Reddit, CTV, podcasts, and Pinterest — run by buyers who\'ve managed nine figures in spend.',
                'detail' => 'Media planning, optimization, and attribution run by buyers who\'ve managed nine figures in spend.',
                'features' => [
                    'Meta, Google, TikTok, X, Reddit',
                    'CTV, podcasts, and Pinterest',
                    'Daily bid and budget management',
                    'Cross-channel attribution',
                ],
            ],
            [
                'number' => '02',
                'title' => 'Creative Services',
                'summary' => 'Concept to production. We write the brief, build the asset, and integrate directly with your internal team — then feed performance data straight back into the next round.',
                'detail' => 'Concept to production, integrated directly with your internal team.',
                'features' => [
                    'Creative brief and concepting',
                    'Asset production',
                    'Direct integration with your team',
                    'Performance data feeds the next round',
                ],
            ],
            [
                'number' => '03',
                'title' => 'CMO Advisory',
                'summary' => 'Business alignment, competitive intelligence, and operational improvements — the full-funnel best practices we\'ve used to future-proof media programs at billion-dollar brands.',
                'detail' => 'The full-funnel best practices we\'ve used to future-proof media programs at billion-dollar brands.',
                'features' => [
                    'Business alignment',
                    'Competitive intelligence',
                    'Operational improvements',
                    'Full-funnel strategy',
                ],
            ],
            [
                'number' => '04',
                'title' => 'CRM Strategy',
                'summary' => 'Email and SMS optimization, database monetization, and customer journey mapping — plus the creative production to actually ship the campaigns.',
                'detail' => 'Email, SMS, and lifecycle work — plus the creative production to actually ship the campaigns.',
                'features' => [
                    'Email and SMS optimization',
                    'Database monetization',
                    'Customer journey mapping',
                    'Campaign creative production',
                ],
            ],
        ] as $i => $row) {
            $features = $row['features'];
            unset($row['features']);

            $service = Service::create($row + ['sort_order' => $i + 1]);

            foreach ($features as $j => $text) {
                $service->features()->create(['text' => $text, 'sort_order' => $j + 1]);
            }
        }
    }
}
