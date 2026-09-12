<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Testimonial> */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quote' => fake()->paragraph(),
            'attribution' => 'Client feedback',
            'author_title' => null,
            'company' => null,
            'is_featured' => false,
            'sort_order' => 0,
            'is_published' => true,
        ];
    }
}
