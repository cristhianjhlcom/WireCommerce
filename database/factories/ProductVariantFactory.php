<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'sku' => strtoupper(fake()->bothify('??####')),
            'color_id' => \App\Models\Color::inRandomOrder()->first()->id ?? null,
            'size_id' => \App\Models\Size::inRandomOrder()->first()->id ?? null,
            'price' => fake()->randomElement([100, 200, 160, 120, 250]),
            'sale_price' => fake()->randomElement([50, 60, 80, null, 45, 90]),
            'image' => null,
            'status' => \App\Enums\ProductsStatusEnum::ACTIVE,
        ];
    }
}
