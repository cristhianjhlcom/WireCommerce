<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

final class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['19 CM', '20 CM', '21 CM', '22 CM', '23 CM', '24 CM', '25 CM', '26 CM', '27 CM', '28 CM', '29 CM', '30 CM'];

        foreach ($sizes as $size) {
            Size::factory()->create([
                'name' => $size,
            ]);
        }
    }
}
