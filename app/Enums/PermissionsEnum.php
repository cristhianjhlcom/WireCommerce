<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionsEnum: string
{
    case VIEW_USERS = 'view_users';
    case CREATE_USERS = 'create_users';
    case UPDATE_USERS = 'update_users';
    case EDIT_USERS = 'edit_users';
    case DELETE_USERS = 'delete_users';
    case RESTORE_USERS = 'restore_users';
    case FORCE_DELETE_USERS = 'force_delete_users';
    case VIEW_PROFILE = 'view_profile';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::VIEW_USERS => __('View Users'),
            self::CREATE_USERS => __('Create Users'),
            self::UPDATE_USERS => __('Update Users'),
            self::EDIT_USERS => __('Edit Users'),
            self::DELETE_USERS => __('Delete Users'),
            self::RESTORE_USERS => __('Restore Users'),
            self::FORCE_DELETE_USERS => __('Force Delete Users'),
            self::VIEW_PROFILE => __('View Profile'),
        };
    }
}
