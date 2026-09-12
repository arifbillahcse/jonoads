<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'quote' => 'Their digital ads expertise is superior. They have integrity, always transparent. Jono is fully invested in our success. I don\'t have to worry about our digital ads anymore — I don\'t have to worry about ads performance anymore.',
                'attribution' => 'Client feedback',
                'is_featured' => true,
                'sort_order' => 1,
            ],
        ] as $row) {
            Testimonial::create($row);
        }
    }
}
