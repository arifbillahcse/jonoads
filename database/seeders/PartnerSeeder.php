<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'name' => '197',
                'category' => 'Social Media + Content',
            ],
            [
                'name' => 'DPM PR',
                'category' => 'Public Relations',
            ],
            [
                'name' => 'Stickybeak',
                'category' => 'Research',
            ],
            [
                'name' => 'Databox',
                'category' => 'Measurement',
            ],
            [
                'name' => 'Studio X',
                'category' => 'Web Development',
            ],
            [
                'name' => 'Catalyst Consulting',
                'category' => 'Product Dev + GTM',
            ],
        ] as $i => $row) {
            Partner::create($row + ['sort_order' => $i + 1]);
        }
    }
}
