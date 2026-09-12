<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'city' => 'Miami',
                'badge' => 'HQ',
                'discipline' => 'Media Buying',
            ],
            [
                'city' => 'New York',
                'badge' => null,
                'discipline' => 'Creative',
            ],
            [
                'city' => 'Dallas',
                'badge' => null,
                'discipline' => 'CRM',
            ],
            [
                'city' => 'Los Angeles',
                'badge' => null,
                'discipline' => 'Accounts',
            ],
            [
                'city' => 'Bay Area',
                'badge' => null,
                'discipline' => 'CRM / Media',
            ],
        ] as $i => $row) {
            Location::create($row + ['sort_order' => $i + 1]);
        }
    }
}
