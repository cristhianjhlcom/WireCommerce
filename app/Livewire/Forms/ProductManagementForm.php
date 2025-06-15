<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Enums\CurrenciesCodeEnum;
use App\Enums\ProductsStatusEnum;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ProductManagementForm extends Form
{
    public ?Product $product = null;

    // NOTE: Basic Information.
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public string $seo_title = '';
    public string $seo_description = '';
    public array $tags = [];
    public int $category = 0;
    public array $images = [];
    public ProductsStatusEnum $status = ProductsStatusEnum::INACTIVE;

    // NOTE: Variant Information.
    public string $variant_sku = '';
    public string $variant_color = '';
    public string $variant_size = '';
    public string $variant_price = '';
    public string $variant_sale_price = '';
    public CurrenciesCodeEnum $variant_currency_code = CurrenciesCodeEnum::PEN;
    public ProductsStatusEnum $variant_status = ProductsStatusEnum::ACTIVE;
    public ?string $variant_image = null;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'min:3',
                Rule::unique('products', 'slug')->ignore($this->product?->id),
            ],
            'description' => ['required', 'string', 'max:1000'],
            'seo_title' => ['nullable', 'string', 'max:60'],
            'seo_description' => ['nullable', 'string', 'max:160'],
            'category' => ['required', 'exists:categories,id'],
            'status' => [
                'required',
                Rule::enum(ProductsStatusEnum::class),
                function ($attribute, $value, $fail) {
                    if (
                        $value === ProductsStatusEnum::ACTIVE->value
                        && $this->product
                        && $this->product->variants->count() === 0
                    ) {
                        $fail(__('Cannot activate product without variants.'));
                    }
                },
            ],
            'tags' => ['nullable', 'array', 'max:4'],
            'tags.*' => ['exists:tags,id'],
        ];
    }

    public function variantRules(): array
    {
        return [
            'variant_sku' => ['required', 'string', 'unique:product_variants,sku'],
            'variant_color' => ['required', 'exists:colors,id'],
            'variant_size' => ['required', 'exists:sizes,id'],
            'variant_price' => ['required', 'numeric', 'min:0'],
            'variant_sale_price' => ['nullable', 'numeric', 'min:0', 'lt:variant_price'],
            'variant_currency_code' => ['required', Rule::enum(CurrenciesCodeEnum::class)],
            'variant_status' => ['required', Rule::enum(ProductsStatusEnum::class)],
            'variant_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The product name is required.'),
            'slug.unique' => __('This URL slug is already in use.'),
            'variant_price.min' => __('Price cannot be negative.'),
            'variant_sale_price.lt' => __('Sale price must be less than regular price.'),
        ];
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->seo_title = $product->seo_title;
        $this->seo_description = $product->seo_description;
        $this->category = $product->category_id;
        $this->status = $product->status;
        $this->tags = $product->tags->pluck('id')->toArray();
    }

    public function store(): array
    {
        return [
            'name' => str()->title($this->name),
            'slug' => $this->slug,
            'description' => $this->description,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'category_id' => $this->category,
            'status' => $this->status,
        ];
    }

    public function storeVariant(): array
    {
        return [
            'sku' => $this->variant_sku,
            'price' => $this->variant_price,
            'sale_price' => $this->variant_sale_price,
            'color_id' => $this->variant_color,
            'size_id' => $this->variant_size,
            'currency_code' => $this->variant_currency_code,
            'status' => $this->variant_status,
            'image' => $this->variant_image,
        ];
    }

    public function resetVariant(): void
    {
        $this->variant_sku = '';
        $this->variant_color = '';
        $this->variant_size = '';
        $this->variant_price = '';
        $this->variant_sale_price = '';
        $this->variant_currency_code = CurrenciesCodeEnum::PEN;
        $this->variant_status = ProductsStatusEnum::ACTIVE;
        $this->variant_image = null;
    }
}
