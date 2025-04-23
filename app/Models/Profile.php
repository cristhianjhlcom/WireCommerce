<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DocumentTypes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'document_type' => DocumentTypes::class,
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
        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->last_name,
        );
    }
}
