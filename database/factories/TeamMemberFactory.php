<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\TeamMember> */
class TeamMemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->jobTitle(),
            'bio' => implode("\n", fake()->paragraphs(2)),
            'photo_path' => null,
            'initials' => null, // derived on save
            'is_founder' => false,
            'sort_order' => 0,
            'is_published' => true,
        ];
    }

    public function founder(): static
    {
        return $this->state(fn () => ['is_founder' => true, 'role' => 'Founder & CEO']);
    }
}
