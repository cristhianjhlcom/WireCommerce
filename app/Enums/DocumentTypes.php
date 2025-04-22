<?php

declare(strict_types=1);

namespace App\Enums;

enum DocumentTypes: string
{
    case Passport = 'passport';
    case CE = 'CE';
    case DNI = 'DNI';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Passport => __('Passport'),
            self::CE => __('Carnet de Extrangería'),
            self::DNI => __('DNI'),
        };
    }
}
