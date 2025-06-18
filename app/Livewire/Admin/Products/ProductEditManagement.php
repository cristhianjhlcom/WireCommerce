<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use Exception;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Enums\ProductsStatusEnum;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Layout, Title};
use App\Livewire\Forms\ProductManagementForm;
use App\Models\{Category, Color, Product, ProductVariant, Size, Tag};

#[Layout(('layouts.admin'))]
#[Title('Product Management')]
final class ProductEditManagement extends Component
{
    use WithFileUploads;

    public ProductManagementForm $form;
    public Product $product;
    // public $variants;
    // public $images;

    public function mount(Product $product)
    {
        // TODO: Add services class to handle all those logic.
        /*
        if (! auth()->user()->can(PermissionsEnum::EDIT_PRODUCTS->value)) {
            abort(403);
        }
        */
        $this->authorize('update', $product);


        // $this->variants = $product->variants;
        // $this->images = $product->images;
        $this->form->setProduct($product);
    }

    public function updating(string $property, mixed $value): void
    {
        if ($property === 'form.name') {
            $this->form->slug = str()->slug($value);
        }
    }

    public function save()
    {
        /*
        if (! auth()->user()->can(PermissionsEnum::UPDATE_PRODUCTS->value)) {
            abort(403);
        }
        */
        $this->authorize('update', $this->form->product);
        $this->form->validate();

        try {
            DB::transaction(function () {
                $this->product->update($this->form->store());
                $this->product->tags()->sync($this->form->tags);
                /*
                if (!empty($form->images)) {
                    $this->handleProductImages($this->form->product, $this->form->images);
                }
                */
                Flux::toast(
                    heading: __('Product Updated'),
                    text: __('Product has been updated successfully.'),
                    variant: 'success',
                );
                $this->redirect(route('admin.products.index'), navigate: true);
            });
        } catch (Exception $e) {
            report($e);
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while updating product: ') . $e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function addVariant()
    {
        $this->authorize('create', $this->product);
        $this->form->validate($this->form->variantRules());
        try {
            DB::transaction(function () {
                $this->product->variants()->create($this->form->storeVariant());
                $this->form->resetVariant();
                Flux::modal('add-variant')->close();
                Flux::toast(
                    heading: __('Variant added successfully'),
                    text: __('You can now edit the variant details.'),
                    variant: 'success',
                );
            });
        } catch (Exception $e) {
            report($e);
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while updating product: ') . $e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function deleteVariant(string $variantId)
    {
        // TODO: Buscar la logica para eliminar la variante del producto.
        // $this->authorize('delete', $variant);
        try {
            $variant = ProductVariant::findOrFail($variantId);
            $variant->delete();
            Flux::toast(
                heading: __('Variant deleted'),
                text: __('The variant has been deleted successfully.'),
                variant: 'success',
            );
        } catch (Exception $e) {
            report($e);
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while deleting variant: ') . $e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        $this->product->load([
            'variants',
            'variants.color',
            'variants.size',
            'tags',
        ]);

        return view('livewire.admin.products.edit', [
            'productTags' => Tag::orderBy('name')->get(),
            'productStatus' => ProductsStatusEnum::cases(),
            'categories' => Category::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
            'sizes' => Size::orderBy('name')->get(),
        ]);
    }
}
