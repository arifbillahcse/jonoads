<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;

class StatSeeder extends Seeder
{
    /**
     * Client feedback round 1 (homepage, top to bottom) reworked these strips:
     *
     * - Media managed is $250M everywhere. The figure appeared as both $225M
     *   (hero, pedigree) and $250M (founder bio, comparison chart); $250M is
     *   the number the client's own copy uses, so the odd one out was fixed.
     * - The undefeated record is 24-0. It read nineteen in some places and
     *   twenty-four in others, same reasoning.
     * - Homepage labels are Title Case per the feedback.
     * - "clients" became "brands" wherever that stat appears.
     */
    public function run(): void
    {
        foreach ([
            // ---- Homepage hero -------------------------------------------
            // "7 Billion-Dollar Brands" moves to the far right; "15+ 9-Figure
            // Brands" takes the slot it used to hold.
            [
                'group' => 'home_hero',
                'label' => 'Media Managed',
                'value' => 250.0,
                'prefix' => '$',
                'suffix' => 'M',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 1,
            ],
            [
                'group' => 'home_hero',
                'label' => 'Revenue Generated',
                'value' => 750.0,
                'prefix' => '$',
                'suffix' => 'M+',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 2,
            ],
            [
                'group' => 'home_hero',
                'label' => '9-Figure Brands',
                'value' => 15.0,
                'prefix' => '',
                'suffix' => '+',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 3,
            ],
            [
                'group' => 'home_hero',
                'label' => 'Brands Scaled',
                'value' => 40.0,
                'prefix' => '',
                'suffix' => '+',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 4,
            ],
            [
                'group' => 'home_hero',
                'label' => 'Billion-Dollar Brands',
                'value' => 7.0,
                'prefix' => '',
                'suffix' => '',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 5,
            ],

            // ---- Pedigree bar --------------------------------------------
            // Six figures keep the 3-column grid filling exactly two rows.
            // "Billion-dollar brand clients" was dropped (it now lives in the
            // hero strip) and "Brands scaled" with it, since the hero carries
            // that too — the two new figures take their places.
            [
                'group' => 'pedigree',
                'label' => 'Media Managed',
                'value' => 250.0,
                'prefix' => '$',
                'suffix' => 'M',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 1,
            ],
            [
                'group' => 'pedigree',
                'label' => 'Revenue Generated',
                'value' => 750.0,
                'prefix' => '$',
                'suffix' => 'M+',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 2,
            ],
            [
                'group' => 'pedigree',
                'label' => 'Combined Years At Mega Brands',
                'value' => 100.0,
                'prefix' => '',
                'suffix' => '+',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 3,
            ],
            [
                'group' => 'pedigree',
                'label' => 'Unique Ads Launched',
                'value' => 150000.0,
                'prefix' => '',
                'suffix' => '',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 4,
            ],
            [
                'group' => 'pedigree',
                'label' => 'Creative Testing Spend',
                'value' => 10.0,
                'prefix' => '$',
                'suffix' => 'M',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 5,
            ],
            [
                'group' => 'pedigree',
                'label' => 'Outperformed Client\'s Prior Team',
                'value' => 100.0,
                'prefix' => '',
                'suffix' => '%',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 6,
            ],

            // ---- ROAS Engine page ----------------------------------------
            [
                'group' => 'engine_hero',
                'label' => 'Point audit in Review',
                'value' => 13.0,
                'prefix' => '',
                'suffix' => '',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 1,
            ],
            [
                'group' => 'engine_hero',
                'label' => 'Media run through the Engine',
                'value' => 250.0,
                'prefix' => '$',
                'suffix' => 'M',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 2,
            ],
            [
                'group' => 'engine_hero',
                'label' => 'Years undefeated',
                'value' => 8.0,
                'prefix' => '',
                'suffix' => '',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 3,
            ],
            [
                'group' => 'engine_hero',
                'label' => 'Contests, zero losses',
                'value' => 24.0,
                'prefix' => '',
                'suffix' => '',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 4,
            ],

            // ---- Team page -----------------------------------------------
            [
                'group' => 'team_hero',
                'label' => 'Combined years at mega brands',
                'value' => 100.0,
                'prefix' => '',
                'suffix' => '+',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 1,
            ],
            [
                'group' => 'team_hero',
                'label' => 'Brands scaled',
                'value' => 40.0,
                'prefix' => '',
                'suffix' => '+',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 2,
            ],
            [
                'group' => 'team_hero',
                'label' => 'Billion-dollar brands',
                'value' => 7.0,
                'prefix' => '',
                'suffix' => '',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 3,
            ],

            // ---- Contact page --------------------------------------------
            [
                'group' => 'contact_hero',
                'label' => 'Access to your team',
                'value' => null,
                'prefix' => '',
                'suffix' => '',
                'decimals' => 0,
                'is_static' => true,
                'static_value' => '24/7',
                'sort_order' => 1,
            ],
            [
                'group' => 'contact_hero',
                'label' => 'Offices, one team',
                'value' => 5.0,
                'prefix' => '',
                'suffix' => '',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 2,
            ],

            // ---- ROAS Engine results strip -------------------------------
            [
                'group' => 'engine_proof',
                'label' => 'Monthly budget scaled',
                'value' => 7.5,
                'prefix' => '',
                'suffix' => 'x',
                'decimals' => 1,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 1,
            ],
            [
                'group' => 'engine_proof',
                'label' => 'ROAS lift in 4 months',
                'value' => 40.0,
                'prefix' => '+',
                'suffix' => '%',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 2,
            ],
            [
                'group' => 'engine_proof',
                'label' => 'To 3x ROAS for one client',
                'value' => 45.0,
                'prefix' => '',
                'suffix' => ' days',
                'decimals' => 0,
                'is_static' => false,
                'static_value' => null,
                'sort_order' => 3,
            ],
        ] as $row) {
            Stat::create($row);
        }
    }
}
