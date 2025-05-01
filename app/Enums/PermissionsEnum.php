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

    case VIEW_CATEGORIES = 'view_categories';
    case CREATE_CATEGORIES = 'create_categories';
    case UPDATE_CATEGORIES = 'update_categories';
    case EDIT_CATEGORIES = 'edit_categories';
    case DELETE_CATEGORIES = 'delete_categories';
    case RESTORE_CATEGORIES = 'restore_categories';
    case FORCE_DELETE_CATEGORIES = 'force_delete_categories';

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

            self::VIEW_CATEGORIES => __('View Categories'),
            self::CREATE_CATEGORIES => __('Create Categories'),
            self::UPDATE_CATEGORIES => __('Update Categories'),
            self::EDIT_CATEGORIES => __('Edit Categories'),
            self::DELETE_CATEGORIES => __('Delete Categories'),
            self::RESTORE_CATEGORIES => __('Restore Categories'),
            self::FORCE_DELETE_CATEGORIES => __('Force Delete Categories'),

            self::VIEW_PROFILE => __('View Profile'),
        };
    }
}
