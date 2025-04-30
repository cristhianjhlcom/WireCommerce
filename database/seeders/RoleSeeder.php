<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create([
            'name' => RolesEnum::SUPER_ADMIN->value,
        ]);
        $userRole = Role::create([
            'name' => RolesEnum::USER->value,
        ]);
        $manageUsersPermission = Permission::create([
            'name' => PermissionsEnum::MANAGE_USERS->value,
        ]);
        $manageOwnProfilePermission = Permission::create([
            'name' => PermissionsEnum::MANAGE_OWN_PROFILE->value,
        ]);

        $superAdminRole->givePermissionTo($manageUsersPermission);
        $userRole->givePermissionTo($manageOwnProfilePermission);
        /*
        $customerRole = Role::create([
            'name' => RolesEnum::CUSTOMER->value,
        ]);
        $vendorRole = Role::create([
            'name' => RolesEnum::VENDOR->value,
        ]);
        $adminRole = Role::create([
            'name' => RolesEnum::ADMIN->value,
        ]);
        */

        /*
        $manageProductsPermission = Permission::create([
            'name' => PermissionsEnum::MANAGE_PRODUCTS->value,
        ]);
        $manageOrdersPermission = Permission::create([
            'name' => PermissionsEnum::MANAGE_ORDERS->value,
        ]);
        */
    }
}
