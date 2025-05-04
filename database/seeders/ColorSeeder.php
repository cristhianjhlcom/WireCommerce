<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

final class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Color::factory()->count(10)->create();
    }
}
