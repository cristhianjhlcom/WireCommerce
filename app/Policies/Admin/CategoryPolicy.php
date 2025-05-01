<?php

declare(strict_types=1);

namespace App\Policies\Admin;

use App\Enums\PermissionsEnum;
use App\Models\Category;
use App\Models\User;

final class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::VIEW_CATEGORIES->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->can(PermissionsEnum::VIEW_CATEGORIES->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::CREATE_CATEGORIES->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->can(PermissionsEnum::UPDATE_CATEGORIES->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->can(PermissionsEnum::DELETE_CATEGORIES->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        return $user->can(PermissionsEnum::RESTORE_CATEGORIES->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return $user->can(PermissionsEnum::FORCE_DELETE_CATEGORIES->value);
    }
}
