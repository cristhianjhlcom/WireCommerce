<?php

namespace App\Models;

use App\Enums\InventoryMovementsType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Inventory extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = 'inventory';

    protected $fillable = [
        'product_variant_id',
        'quantity',
        'reserved_quantity',
        'warehouse_location',
    ];

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'product_variant_id', 'product_variant_id');
    }

    public function updateInventoryQuantity(int $amount, InventoryMovementsType $type, ?string $reference = null): void
    {
        $movement = new InventoryMovement([
            'product_variant_id' => $this->product_variant_id,
            'type' => $type,
            'quantity' => abs($amount),
            'reference' => $reference,
            'user_id' => auth()->id(),
        ]);

        $movement->save();

        match ($type) {
            InventoryMovementsType::ADDITION => $this->increment('quantity', abs($amount)),
            InventoryMovementsType::SUBTRACTION => $this->decrement('quantity', abs($amount)),
            InventoryMovementsType::RESERVATION => $this->increment('reserved_quantity', abs($amount)),
            InventoryMovementsType::RELEASE => $this->decrement('reserved_quantity', abs($amount)),
            default => throw new \Exception('Invalid type'),
        };
    }
}
