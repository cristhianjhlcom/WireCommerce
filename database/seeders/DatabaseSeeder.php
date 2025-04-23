<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'email' => 'admin@email.com',
            'password' => '12345678',
        ]);

        $admin->profile()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
        ]);

        $this->call([
            UserSeeder::class,
        ]);
    }
}
