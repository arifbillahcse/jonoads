<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * The three quotes the client supplied for round 1 — the original
     * "Lens & Eyewear Client" quote from before this round is dropped
     * entirely rather than kept alongside them, per the client's own
     * instruction to keep only these three.
     *
     * `attribution` is the only credit line the view renders; the separate
     * author_title/company columns are unused, so each credit is stored whole.
     */
    public function run(): void
    {
        foreach ([
            [
                'quote' => 'Big fan. They have integrity, fantastic team. Worked with them at small and large brands.',
                'attribution' => 'Client Chief Digital Officer',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'quote' => 'Highly recommend. Joseph and his team are the real deal. Hired them at several of my companies.',
                'attribution' => 'Digital Marketing Director, Global Mobile Tech Brand',
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'quote' => 'Strongly recommend. Established stability and achieved ROAS goal fast. Reduced internal workload.',
                'attribution' => 'President, Global Fitness App & Consumer Wearables',
                'is_featured' => false,
                'sort_order' => 3,
            ],
        ] as $row) {
            Testimonial::create($row);
        }
    }
}
