<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // NOTE: Permissions for users model actions.
        foreach (PermissionsEnum::values() as $permission) {
            Permission::create(['name' => $permission]);
        }

        // NOTE: Create Role Super-Admin and assign all permissions to it.
        $superAdmin = Role::create(['name' => RolesEnum::SUPER_ADMIN->value]);
        $superAdmin->givePermissionTo(Permission::all());

        // NOTE: Create Role User with limited permissions.
        $user = Role::create(['name' => RolesEnum::USER->value]);
        $user->givePermissionTo([PermissionsEnum::VIEW_PROFILE->value]);

        // NOTE: Create a Super Admin users.
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin@email.com',
            'password' => '12345678',
        ])->assignRole(RolesEnum::SUPER_ADMIN->value);
        $admin->profile()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
        ]);
        $admin->assignRole(RolesEnum::SUPER_ADMIN->value);
    }
}
