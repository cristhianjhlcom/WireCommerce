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

    case VIEW_PRODUCTS = 'view_products';
    case CREATE_PRODUCTS = 'create_products';
    case UPDATE_PRODUCTS = 'update_products';
    case EDIT_PRODUCTS = 'edit_products';
    case DELETE_PRODUCTS = 'delete_products';
    case RESTORE_PRODUCTS = 'restore_products';
    case FORCE_DELETE_PRODUCTS = 'force_delete_products';

    case VIEW_TAGS = 'view_tags';
    case CREATE_TAGS = 'create_tags';
    case UPDATE_TAGS = 'update_tags';
    case EDIT_TAGS = 'edit_tags';
    case DELETE_TAGS = 'delete_tags';
    case RESTORE_TAGS = 'restore_tags';
    case FORCE_DELETE_TAGS = 'force_delete_tags';

    case VIEW_COLORS = 'view_colors';
    case CREATE_COLORS = 'create_colors';
    case UPDATE_COLORS = 'update_colors';
    case EDIT_COLORS = 'edit_colors';
    case DELETE_COLORS = 'delete_colors';
    case RESTORE_COLORS = 'restore_colors';
    case FORCE_DELETE_COLORS = 'force_delete_colors';

    case VIEW_SIZES = 'view_sizes';
    case CREATE_SIZES = 'create_sizes';
    case UPDATE_SIZES = 'update_sizes';
    case EDIT_SIZES = 'edit_sizes';
    case DELETE_SIZES = 'delete_sizes';
    case RESTORE_SIZES = 'restore_sizes';
    case FORCE_DELETE_SIZES = 'force_delete_sizes';

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

            self::VIEW_PRODUCTS => __('View Products'),
            self::CREATE_PRODUCTS => __('Create Products'),
            self::UPDATE_PRODUCTS => __('Update Products'),
            self::EDIT_PRODUCTS => __('Edit Products'),
            self::DELETE_PRODUCTS => __('Delete Products'),
            self::RESTORE_PRODUCTS => __('Restore Products'),
            self::FORCE_DELETE_PRODUCTS => __('Force Delete Products'),

            self::VIEW_CATEGORIES => __('View Categories'),
            self::CREATE_CATEGORIES => __('Create Categories'),
            self::UPDATE_CATEGORIES => __('Update Categories'),
            self::EDIT_CATEGORIES => __('Edit Categories'),
            self::DELETE_CATEGORIES => __('Delete Categories'),
            self::RESTORE_CATEGORIES => __('Restore Categories'),
            self::FORCE_DELETE_CATEGORIES => __('Force Delete Categories'),

            self::VIEW_COLORS => __('View Colors'),
            self::CREATE_COLORS => __('Create Colors'),
            self::UPDATE_COLORS => __('Update Colors'),
            self::EDIT_COLORS => __('Edit Colors'),
            self::DELETE_COLORS => __('Delete Colors'),
            self::RESTORE_COLORS => __('Restore Colors'),
            self::FORCE_DELETE_COLORS => __('Force Delete Colors'),

            self::VIEW_SIZES => __('View Sizes'),
            self::CREATE_SIZES => __('Create Sizes'),
            self::UPDATE_SIZES => __('Update Sizes'),
            self::EDIT_SIZES => __('Edit Sizes'),
            self::DELETE_SIZES => __('Delete Sizes'),
            self::RESTORE_SIZES => __('Restore Sizes'),
            self::FORCE_DELETE_SIZES => __('Force Delete Sizes'),

            self::VIEW_TAGS => __('View Tags'),
            self::CREATE_TAGS => __('Create Tags'),
            self::UPDATE_TAGS => __('Update Tags'),
            self::EDIT_TAGS => __('Edit Tags'),
            self::DELETE_TAGS => __('Delete Tags'),
            self::RESTORE_TAGS => __('Restore Tags'),
            self::FORCE_DELETE_TAGS => __('Force Delete Tags'),
            self::VIEW_PROFILE => __('View Profile'),
        };
    }
}
