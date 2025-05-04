<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class Tag extends Model implements Auditable
{
    use AuditableTrait, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    protected $casts = [
        'icon' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function createdAtHuman(): string
    {
        return $this->created_at->locale('es')->diffForHumans();
    }

    public function updatedAtHuman(): string
    {
        return $this->updated_at->locale('es')->diffForHumans();
    }
}
