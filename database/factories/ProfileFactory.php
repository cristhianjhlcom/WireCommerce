<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\DocumentsTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
final class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->phoneNumber(),
            'document_type' => DocumentsTypeEnum::DNI,
            'document_number' => fake()->numerify('###########'),
            'avatar' => null,
        ];
    }
}
