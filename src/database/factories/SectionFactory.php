<?php

namespace Otas\DynamicPages\database\factories;

use Otas\DynamicPages\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_id' => Page::factory(),
            'identifier' => $this->faker->unique()->slug(),
            'has_title' => $this->faker->boolean(50),
            'has_description' => $this->faker->boolean(50),
            'images_count' => $this->faker->numberBetween(1, 10),
            'has_items' => $this->faker->boolean(50),
            'item_images_count' => $this->faker->numberBetween(1, 10),
            'has_items_title' => $this->faker->boolean(50),
            'has_items_description' => $this->faker->boolean(50),
            'title_validation_text' => $this->faker->sentence(),
            'description_validation_text' => $this->faker->sentence(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($section) {
            $section->translate([
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
