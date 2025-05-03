<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'icon' => '🔥',
                'name' => 'Hot Sale',
                'slug' => 'hot-sale',
            ],
            [
                'icon' => '⚡',
                'name' => 'Flash Sale',
                'slug' => 'flash-sale',
            ],
            [
                'icon' => '⭐',
                'name' => 'Unique Offer',
                'slug' => 'unique-offer',
            ],
            [
                'icon' => '🏷️',
                'name' => 'Offer',
                'slug' => 'offer',
            ],
            [
                'icon' => '😎',
                'name' => 'Happy',
                'slug' => 'happy',
            ],
        ];

        foreach ($tags as $tag) {
            Tag::factory()->state($tag)->create();
        }
    }
}
