<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductsStatusEnum: string
{
    case DRAFT = 'draft';
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case PUBLISHED = 'published';
    case OUT_OF_STOCK = 'out_of_stock';
    case IN_STOCK = 'in_stock';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => __('Draft'),
            self::INACTIVE => __('Inactive'),
            self::ACTIVE => __('Active'),
            self::PUBLISHED => __('Published'),
            self::OUT_OF_STOCK => __('Out of Stock'),
            self::IN_STOCK => __('In Stock'),
        };
    }
}
