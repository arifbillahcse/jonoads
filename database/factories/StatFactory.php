<?php

namespace Database\Factories;

use App\Models\Stat;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Stat> */
class StatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'group' => array_rand(Stat::GROUPS),
            'label' => fake()->words(3, true),
            'value' => fake()->numberBetween(5, 900),
            'prefix' => '',
            'suffix' => '',
            'decimals' => 0,
            'is_static' => false,
            'static_value' => null,
            'sort_order' => 0,
            'is_published' => true,
        ];
    }

    /** A slogan-style figure such as "24/7" that must not animate. */
    public function static(string $value = '24/7'): static
    {
        return $this->state(fn () => [
            'is_static' => true,
            'static_value' => $value,
            'value' => null,
        ]);
    }
}
