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
}
