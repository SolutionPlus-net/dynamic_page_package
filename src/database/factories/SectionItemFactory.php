<?php

namespace Otas\DynamicPages\database\factories;

use Otas\DynamicPages\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SectionItem>
 */
class SectionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'section_id' => Section::factory(),
            'identifier' => $this->faker->unique()->slug(),
            'title_validation_text' => $this->faker->sentence(),
            'description_validation_text' => $this->faker->sentence(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($item) {
            $item->translate([
                'name' => $this->faker->words(2, true),
                'title' => $this->faker->sentence(),
                'description' => $this->faker->paragraph(),
            ], 'en')->translate([
                'name' => $this->faker->words(2, true),
                'title' => $this->faker->sentence(),
                'description' => $this->faker->paragraph(),
            ], 'ar');
        });
    }
}
