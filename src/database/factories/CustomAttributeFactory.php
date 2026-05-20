<?php

namespace Otas\DynamicPages\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomAttribute>
 */
class CustomAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word(),
            'value_validation_text' => $this->faker->sentence(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($customAttribute) {
            $customAttribute->translate([
                'name' => $this->faker->words(2, true),
                'value' => $this->faker->sentence(),
            ], 'en')->translate([
                'name' => $this->faker->words(2, true),
                'value' => $this->faker->sentence(),
            ], 'ar');
        });
    }
}
