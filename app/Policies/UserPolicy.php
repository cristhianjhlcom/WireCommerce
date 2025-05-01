<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;

final class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::VIEW_USERS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can(PermissionsEnum::VIEW_USERS->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::CREATE_USERS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->can(PermissionsEnum::UPDATE_USERS->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can(PermissionsEnum::DELETE_USERS->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can(PermissionsEnum::RESTORE_USERS->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can(PermissionsEnum::FORCE_DELETE_USERS->value);
    }
}
