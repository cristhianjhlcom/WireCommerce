<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\DocumentsTypeEnum;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_user_with_profile(): void
    {
        // Create User.
        $user = User::factory()->create();

        // Create Profile.
        $user->profile()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '123456789',
            'document_type' => DocumentsTypeEnum::DNI,
            'document_number' => '123456789',
            'avatar' => null,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '123456789',
            'document_type' => DocumentsTypeEnum::DNI,
            'document_number' => '123456789',
            'avatar' => null,
        ]);

        $this->assertTrue($user->profile->exists());
        $this->assertEquals('John', $user->profile->first_name);
    }

    #[Test]
    public function can_update_user_and_profile(): void
    {
        // Create user with profile using factory.
        $user = User::factory()
            ->has(Profile::factory())
            ->create();

        // Update user.
        $user->update([
            'email' => 'jane@example.com',
        ]);

        // Update profile.
        $user->profile->update([
            'first_name' => 'Jane',
            'last_name' => 'Doe Updated',
            'phone_number' => '987654321',
        ]);

        // Load model of database.
        $user->refresh();

        // Assertions
        $this->assertEquals('Jane', $user->profile->first_name);
        $this->assertEquals('jane@example.com', $user->email);
        $this->assertEquals('987654321', $user->profile->phone_number);
    }

    #[Test]
    public function can_delete_user_and_profile(): void
    {
        // Create user with profile.
        $user = User::factory()
            ->has(Profile::factory())
            ->create();

        // Save IDs to verify later.
        $userId = $user->id;
        $profileId = $user->profile->id;

        // Delete user.
        $user->delete();

        // Assertions
        $this->assertDatabaseMissing('users', ['id' => $userId]);
        $this->assertDatabaseMissing('profiles', ['id' => $profileId]);
    }

    #[Test]
    public function can_create_user_through_factory(): void
    {
        $user = User::factory()
            ->has(Profile::factory())
            ->create();

        $this->assertNotNull($user->profile);
        $this->assertInstanceOf(Profile::class, $user->profile);
    }

    #[Test]
    public function profile_belongs_to_correct_user(): void
    {
        $user = User::factory()
            ->has(Profile::factory())
            ->create();

        $this->assertEquals($user->id, $user->profile->user_id);
        $this->assertTrue($user->profile->user()->is($user));
    }
}
