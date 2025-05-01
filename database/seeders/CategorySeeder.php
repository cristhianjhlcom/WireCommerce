<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Electronics', 'Clothing', 'Home', 'Toys', 'Books', 'Movies'];

        foreach ($categories as $category) {
            Category::factory()->state([
                'name' => $category,
                'slug' => Str::slug($category),
            ])->create();
        }
    }
}
