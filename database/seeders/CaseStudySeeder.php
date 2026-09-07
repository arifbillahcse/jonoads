<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;

class CaseStudySeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'client' => 'Sunglasses Co.',
                'summary' => 'Rebuilt Meta audiences and campaign architecture, then switched to active ads management.',
                'stats' => [
                    [
                        'label' => 'Monthly budget',
                        'value' => 7.5,
                        'prefix' => '',
                        'suffix' => 'x',
                        'decimals' => 1,
                    ],
                    [
                        'label' => 'ROAS in 4 months',
                        'value' => 40.0,
                        'prefix' => '+',
                        'suffix' => '%',
                        'decimals' => 0,
                    ],
                ],
            ],
            [
                'client' => 'Lenses Brand',
                'summary' => 'Reduced campaign overlap, rebuilt audiences, added active ads management and a creative testing pipeline. Revenue up +30% YoY.',
                'stats' => [
                    [
                        'label' => 'Monthly budget',
                        'value' => 4.0,
                        'prefix' => '',
                        'suffix' => 'x',
                        'decimals' => 0,
                    ],
                    [
                        'label' => 'ROAS',
                        'value' => 30.0,
                        'prefix' => '+',
                        'suffix' => '%',
                        'decimals' => 0,
                    ],
                ],
            ],
            [
                'client' => 'Global App (Lead Gen)',
                'summary' => 'Updated the lead page, added martech, new Meta and Google creative and campaigns, sunset underperforming display ads.',
                'stats' => [
                    [
                        'label' => 'Cost per lead, down from ~$385',
                        'value' => 20.0,
                        'prefix' => '$',
                        'suffix' => '',
                        'decimals' => 0,
                    ],
                ],
            ],
            [
                'client' => 'Supplement Co.',
                'summary' => 'Outperformed the incumbent top US agency. New Meta and Google structure, active management, all-new creative and landing page.',
                'stats' => [
                    [
                        'label' => 'Budget',
                        'value' => 3.0,
                        'prefix' => '',
                        'suffix' => 'x',
                        'decimals' => 0,
                    ],
                    [
                        'label' => 'ROAS in 45 days',
                        'value' => 3.0,
                        'prefix' => '',
                        'suffix' => 'x',
                        'decimals' => 0,
                    ],
                ],
            ],
            [
                'client' => 'Non-Alcoholic Whiskey',
                'summary' => 'Beat a global top Google ads agency by 70% on ROAS with new campaign structure, creative, and active management.',
                'stats' => [
                    [
                        'label' => 'Monthly budget',
                        'value' => 18.0,
                        'prefix' => '',
                        'suffix' => 'x',
                        'decimals' => 0,
                    ],
                    [
                        'label' => 'ROAS',
                        'value' => 2.0,
                        'prefix' => '',
                        'suffix' => 'x',
                        'decimals' => 0,
                    ],
                ],
            ],
            [
                'client' => 'Fitness App',
                'summary' => 'Displaced a large incumbent US agency. New campaign structures, landing pages, 100% new creative, active management.',
                'stats' => [
                    [
                        'label' => 'ROAS',
                        'value' => 3.0,
                        'prefix' => '',
                        'suffix' => 'x',
                        'decimals' => 0,
                    ],
                    [
                        'label' => 'Monthly budget',
                        'value' => 2.0,
                        'prefix' => '',
                        'suffix' => 'x',
                        'decimals' => 0,
                    ],
                ],
            ],
        ] as $i => $row) {
            $stats = $row['stats'];
            unset($row['stats']);

            $case = CaseStudy::create($row + ['sort_order' => $i + 1]);

            foreach ($stats as $j => $stat) {
                $case->stats()->create($stat + ['sort_order' => $j + 1]);
            }
        }
    }
}
