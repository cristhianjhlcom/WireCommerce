<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class Setting extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'value' => 'json',
    ];

    /**
     * Obtiene el valor de una configuración
     *
     * @param  mixed  $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Establece un valor de configuración
     *
     * @param  mixed  $value
     * @return Setting
     */
    public static function set(string $key, $value, string $group = 'general', string $type = 'string', bool $isPublic = false)
    {
        $setting = self::firstOrNew(['key' => $key]);

        $setting->value = $value;
        $setting->group = $group;
        $setting->type = $type;
        $setting->is_public = $isPublic;

        $setting->save();

        return $setting;
    }

    /**
     * Obtiene todas las configuraciones públicas
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllPublic()
    {
        return self::where('is_public', true)->get()->pluck('value', 'key');
    }

    /**
     * Obtiene todas las configuraciones agrupadas
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getAllGrouped()
    {
        return self::all()->groupBy('group');
    }
}
