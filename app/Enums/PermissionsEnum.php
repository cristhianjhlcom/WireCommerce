<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionsEnum: string
{
    // case APPROVED_VENDORS = 'approved_vendors';
    // case SELL_PRODUCTS = 'sell_products';
    // case BUY_PRODUCTS = 'buy_products';
    // case MANAGE_PRODUCTS = 'manage_products';
    // case MANAGE_ORDERS = 'manage_orders';
    // case MANAGE_CUSTOMERS = 'manage_customers';
    case MANAGE_OWN_PROFILE = 'manage_own_profile';
    case MANAGE_OWN_ORDER = 'manage_own_order';
    case MANAGE_USERS = 'manage_users';
}
