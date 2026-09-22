<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Three quotes, which is what the rotating testimonial band needs — the
     * client supplied two more alongside the original and asked that they
     * auto-advance. Until that carousel lands the page still shows only the
     * featured one.
     *
     * `attribution` is the only credit line the view renders; the separate
     * author_title/company columns are unused, so each credit is stored whole.
     */
    public function run(): void
    {
        foreach ([
            [
                'quote' => 'Their digital ads expertise is superior. They have integrity, always transparent. Jono is fully invested in our success. I don\'t have to worry about our digital ads anymore — I don\'t have to worry about ads performance anymore.',
                'attribution' => 'Lens & Eyewear Client',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'quote' => 'Big fan. They have integrity, fantastic team. Worked with them at small and large brands.',
                'attribution' => 'Client Chief Digital Officer',
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'quote' => 'Highly recommend. Joseph and his team are the real deal. Hired them at several of my companies.',
                'attribution' => 'Digital Marketing Director, Global Mobile Tech Brand',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'quote' => 'Strongly recommend. Established stability and achieved ROAS goal fast. Reduced internal workload.',
                'attribution' => 'President, Global Fitness App & Consumer Wearables',
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ] as $row) {
            Testimonial::create($row);
        }
    }
}
