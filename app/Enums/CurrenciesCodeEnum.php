<?php

declare(strict_types=1);

namespace App\Enums;

enum CurrenciesCodeEnum: string
{
    case PEN = 'PEN';
    case USD = 'USD';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::PEN => __('PEN'),
            self::USD => __('USD'),
        };
    }
}
