<?php

namespace Otas\DynamicPages\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Otas\DynamicPages\Models\Page;

class PageFactory extends Factory
{
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => $this->faker->unique()->slug(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($page) {
            $page->translate([
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
