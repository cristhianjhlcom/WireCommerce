<?php

declare(strict_types=1);

namespace App\Enums;

enum InventoryMovementsType: string
{
    case ADDITION = 'addition';
    case SUBTRACTION = 'subtraction';
    case RESERVATION = 'reservation';
    case RELEASE = 'release';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::ADDITION => __('Addition'),
            self::SUBTRACTION => __('Subtraction'),
            self::RESERVATION => __('Reservation'),
            self::RELEASE => __('Release'),
        };
    }
}
