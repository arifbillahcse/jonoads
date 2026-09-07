<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\NewsletterSubscriber> */
class NewsletterSubscriberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'status' => 'pending',
            'confirmation_token' => Str::random(48),
            'source_page' => '/contact',
            'ip_address' => fake()->ipv4(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn () => [
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'confirmation_token' => null,
        ]);
    }
}
