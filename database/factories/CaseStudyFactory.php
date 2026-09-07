<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\CaseStudy> */
class CaseStudyFactory extends Factory
{
    public function definition(): array
    {
        $client = fake()->company();

        return [
            'client' => $client,
            'slug' => Str::slug($client) . '-' . fake()->unique()->numberBetween(1, 99999),
            'summary' => fake()->sentence(14),
            'detail' => fake()->paragraph(),
            'is_featured' => false,
            'sort_order' => 0,
            'is_published' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    public function unpublished(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}
