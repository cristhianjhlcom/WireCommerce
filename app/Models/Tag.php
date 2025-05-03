<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Tag extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

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
