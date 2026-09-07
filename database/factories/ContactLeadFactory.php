<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\ContactLead> */
class ContactLeadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'company' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'monthly_spend' => fake()->randomElement(['<$10k', '$10k–$50k', '$50k–$250k', '$250k+']),
            'message' => fake()->paragraph(),
            'status' => 'new',
            'source_page' => '/contact',
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }
}
