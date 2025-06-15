<?php

declare(strict_types=1);

namespace App\Services\Admin;

use Exception;
use App\Models\Product;
use App\Enums\ProductsStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\ProductManagementForm;

final class ProductManagementServices
{
    /**
     * Create a new product with its relationships
     */
    public function create(ProductManagementForm $form): Product
    {
        return DB::transaction(function () use ($form) {
            $product = Product::create($form->store());

            if (!empty($form->tags)) {
                $product->tags()->sync($form->tags);
            }

            if (!empty($form->images)) {
                $this->handleProductImages($product, $form->images);
            }

            return $product;
        });
    }

    /**
     * Update an existing product
     */
    public function update(Product $product, ProductManagementForm $form): Product
    {
        return DB::transaction(function () use ($product, $form) {
            $product->update($form->store());

            $product->tags()->sync($form->tags);

            if (!empty($form->images)) {
                $this->handleProductImages($product, $form->images);
            }

            return $product->fresh();
        });
    }

    /**
     * Add a new variant to the product
     */
    public function addVariant(Product $product, ProductManagementForm $form): void
    {
        DB::transaction(function () use ($product, $form) {
            $variantData = $form->storeVariant();

            if ($form->variant_image) {
                $variantData['image'] = $this->handleVariantImage($form->variant_image);
            }

            $product->variants()->create($variantData);
        });
    }

    /**
     * Delete a product variant
     */
    public function deleteVariant(Product $product, int $variantId): void
    {
        DB::transaction(function () use ($product, $variantId) {
            $variant = $product->variants()->findOrFail($variantId);

            if ($variant->image) {
                Storage::delete($variant->image);
            }

            $variant->delete();

            if ($product->variants()->count() === 0) {
                $product->update(['status' => ProductsStatusEnum::INACTIVE]);
            }
        });
    }

    /**
     * Handle product status change
     */
    public function updateStatus(Product $product, ProductsStatusEnum $status): void
    {
        if ($status === ProductsStatusEnum::ACTIVE && !$product->variants()->exists()) {
            throw new Exception(__('Cannot activate product without variants.'));
        }

        $product->update(['status' => $status]);
    }

    /**
     * Handle product images upload
     */
    private function handleProductImages(Product $product, array $images): void
    {
        foreach ($images as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create(['path' => $path]);
        }
    }

    /**
     * Handle variant image upload
     */
    private function handleVariantImage($image): string
    {
        return $image->store('variants', 'public');
    }

    /**
     * Delete a product and all its relationships
     */
    public function delete(Product $product): void
    {
        DB::transaction(function () use ($product) {
            foreach ($product->images as $image) {
                Storage::delete($image->path);
                $image->delete();
            }

            foreach ($product->variants as $variant) {
                if ($variant->image) {
                    Storage::delete($variant->image);
                }
                $variant->delete();
            }

            $product->tags()->detach();

            $product->delete();
        });
    }

    /**
     * Duplicate a product with its relationships
     */
    public function duplicate(Product $product): Product
    {
        return DB::transaction(function () use ($product) {
            $newProduct = $product->replicate();
            $newProduct->name = "{$product->name} (Copy)";
            $newProduct->slug = "{$product->slug}-copy";
            $newProduct->status = ProductsStatusEnum::INACTIVE;
            $newProduct->save();

            // Duplicar tags
            $newProduct->tags()->sync($product->tags);

            // Duplicar variantes
            foreach ($product->variants as $variant) {
                $newVariant = $variant->replicate();
                $newVariant->sku = "{$variant->sku}-copy";
                $newProduct->variants()->save($newVariant);
            }

            return $newProduct;
        });
    }

    /**
     * Validate if product can be activated
     */
    public function canBeActivated(Product $product): bool
    {
        return $product->variants()->exists();
    }
}
