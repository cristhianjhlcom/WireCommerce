<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Enums\PermissionsEnum;
use App\Models\Product;
use App\Models\ProductVariant;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Product Management')]
final class ProductIndexManagement extends Component
{
    public function delete(Product $product)
    {
        if (! auth()->user()->can(PermissionsEnum::DELETE_PRODUCTS->value)) {
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('You cannot delete products.'),
                variant: 'error',
            );
        }

        $product->delete();

        Flux::toast(
            heading: __('Product deleted'),
            text: __('The product has been deleted.'),
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.admin.products.index', [
            'variants' => ProductVariant::with([
                'product',
                'product.category',
                'product.tags',
                'product.variants',
                'product.images'
            ])
                ->latest()
                ->paginate(16),
        ]);
    }
}
