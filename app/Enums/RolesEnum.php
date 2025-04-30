<?php

declare(strict_types=1);

namespace App\Enums;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'super_admin';
    case USER = 'user';
    // case ADMIN = 'admin';
    // case VENDOR = 'vendor';
    // case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => __('Super Admin'),
            self::USER => __('User'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'orange',
            self::USER => 'indigo',
        };
    }
}
