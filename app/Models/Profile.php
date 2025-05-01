<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DocumentsTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

final class Profile extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $auditExclude = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'document_type' => DocumentsTypeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documentTypeLabel(): string
    {
        return $this->document_type->label();
    }

    protected function fullName(): Attribute
    {
        if (! $this->first_name && ! $this->last_name) {
            return Attribute::make(
                get: fn () => '-',
            );
        }

        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->last_name,
        );
    }
}
