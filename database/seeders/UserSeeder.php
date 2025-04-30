<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)
            ->has(Profile::factory())
            ->create()
            ->each(function (User $user) {
                $user->assignRole(RolesEnum::USER->value);
            });
    }
}
