<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = fake()->words(3, true),
            'slug' => str()->slug($name),
            'description' => fake()->paragraph(3, true),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? \App\Models\Category::factory()->create()->id,
            'seo_title' => fake()->sentence(),
            'seo_description' => fake()->paragraph(),
            'status' => fake()->randomElement(\App\Enums\ProductsStatusEnum::values()),
        ];
    }
}
