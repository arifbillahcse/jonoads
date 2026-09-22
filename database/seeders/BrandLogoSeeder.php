<?php

namespace Database\Seeders;

use App\Models\BrandLogo;
use Illuminate\Database\Seeder;

class BrandLogoSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'GM',
            'Lexus',
            'StubHub',
            'Beachbody',
            'Les Mills',
            'Crexi',
            'Fuse Lenses',
            'Pvolve',
            'Aarmy',
            'InMobi',
            'SideChef',
            'Stickybeak',
            'Muse',
            'MRM',
            'AOL',
            'Gen',
            'The Bouqs Co.',
        ] as $i => $name) {
            BrandLogo::create(['name' => $name, 'sort_order' => $i + 1]);
        }
    }
}
