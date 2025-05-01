<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

final class User extends Authenticatable implements Auditable
{
    use HasFactory, HasRoles, Notifiable, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $auditInclude = [
        'id',
        'email',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function createdAtHuman(): string
    {
        return $this->created_at->locale('es')->diffForHumans();
    }

    public function isAdministrator(): bool
    {
        return (bool) ($this->hasRole(RolesEnum::SUPER_ADMIN->value));
    }

    public function getRoles(): Collection
    {
        return $this->getRoleNames()->map(function ($role) {
            return RolesEnum::from($role);
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }
}
