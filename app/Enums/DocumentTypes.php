<?php

declare(strict_types=1);

namespace App\Enums;

enum DocumentTypes: string
{
    case Passport = 'passport';
    case CE = 'ce';
    case DNI = 'dni';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Passport => __('Pasaporte'),
            self::CE => __('Carnet de Extranjería'),
            self::DNI => __('DNI'),
        };
    }
}
