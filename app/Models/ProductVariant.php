<?php

namespace App\Models;

use App\Enums\CurrenciesCodeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProductVariant extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'product_id',
        'sku',
        'color_id',
        'size_id',
        'price',
        'sale_price',
        'currency_code',
        'image',
        'status',
    ];

    protected $casts = [
        'sale_price' => 'integer',
        'status' => \App\Enums\ProductsStatusEnum::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    // Métodos para trabajar con Money
    public function getPrice(): Money
    {
        return new Money($this->price, new Currency($this->currency_code ?? CurrenciesCodeEnum::PEN->value));
    }

    public function getSalePrice(): ?Money
    {
        if ($this->sale_price === null) {
            return null;
        }

        return new Money($this->sale_price, new Currency($this->currency_code ?? CurrenciesCodeEnum::PEN->value));
    }

    public function getCurrentPrice(): Money
    {
        return $this->getSalePrice() ?? $this->getPrice();
    }

    // Para formatear el precio según la localización
    public function getFormattedPrice(string $locale = 'es_PE'): string
    {
        $money = $this->getPrice();
        return $this->formatMoney($money, $locale);
    }

    public function getFormattedSalePrice(string $locale = 'es_PE'): ?string
    {
        $money = $this->getSalePrice();

        if ($money === null) {
            return null;
        }

        return $this->formatMoney($money, $locale);
    }

    public function getFormattedCurrentPrice(string $locale = 'es_PE'): string
    {
        $money = $this->getCurrentPrice();
        return $this->formatMoney($money, $locale);
    }

    // Método para calcular descuento
    public function getDiscountPercentage(): ?int
    {
        if ($this->sale_price === null || $this->price <= 0) {
            return null;
        }

        return (int) round((1 - ($this->sale_price / $this->price)) * 100);
    }

    // Métodos privados de ayuda
    private function formatMoney(Money $money, string $locale): string
    {
        $numberFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($money);
    }

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function isInStock(): bool
    {
        return $this->inventory && ($this->inventory->quantity - $this->inventory->reserved_quantity) > 0;
    }

    public function getAvailableQuantityAttribute(): int
    {
        if (!$this->inventory) {
            return 0;
        }

        return max(0, $this->inventory->quantity - $this->inventory->reserved_quantity);
    }
}
