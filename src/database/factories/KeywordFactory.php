<?php

namespace Otas\DynamicPages\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keyword>
 */
class KeywordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_visible' => $this->faker->boolean(50),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($keyword) {
            $keyword->translate([
                'name' => $this->faker->words(2, true),
            ], 'en')->translate([
                'name' => $this->faker->words(2, true),
            ], 'ar');
        });
    }
}
