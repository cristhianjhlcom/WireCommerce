<?php

namespace Database\Seeders;

use App\Enums\CurrenciesCodeEnum;
use App\Enums\ProductsStatusEnum;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $tags = Tag::all();
        $colors = Color::all();
        $sizes = Size::all();

        for ($idx = 1; $idx <= 20; $idx++) {
            $product = Product::factory()->create([
                'name' => $name = str()->title(fake()->words(3, true)),
                'slug' => str()->slug($name),
                'description' => fake()->paragraph(3, true),
                'category_id' => $categories->random()->id ?? $categories->first()->id,
                'seo_title' => fake()->sentence(),
                'seo_description' => fake()->paragraph(),
                'status' => fake()->randomElement([
                    ProductsStatusEnum::PUBLISHED,
                    ProductsStatusEnum::INACTIVE,
                ]),
            ]);
            $product->tags()->attach($tags->random(rand(2, 5))->pluck("id")->toArray());
            $variantsCount = rand(3, 5);
            Log::info("Product {$product->name} has {$variantsCount} variants.");
            for ($j = 1; $j <= $variantsCount; $j++) {
                Log::info("Product {$product->name} current variant idx {$j}");
                $price = fake()->numberBetween(5000, 50000);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => strtoupper(fake()->bothify('??##??##')),
                    'color_id' => $colors->random()->id,
                    'size_id' => $sizes->random()->id,
                    'price' => $price,
                    'sale_price' => rand(0, 1) ? $price - fake()->numberBetween(1000, 5000) : null,
                    'currency_code' => CurrenciesCodeEnum::PEN->value,
                    'image' => fake()->imageUrl(640, 480),
                    'status' => fake()->randomElement([
                        ProductsStatusEnum::OUT_OF_STOCK,
                        ProductsStatusEnum::IN_STOCK,
                    ]),
                ]);
            }
        }
    }
}
