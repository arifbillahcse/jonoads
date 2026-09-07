<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\CaseStudyStat> */
class CaseStudyStatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'case_study_id' => CaseStudy::factory(),
            'label' => fake()->words(2, true),
            'value' => fake()->numberBetween(2, 40),
            'prefix' => '',
            'suffix' => 'x',
            'decimals' => 0,
            'sort_order' => 0,
        ];
    }
}
