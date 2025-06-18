<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use Exception;
use Flux\Flux;
use Livewire\Component;
use App\Enums\ProductsStatusEnum;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Layout, Title};
use App\Models\{Category, Color, Product, Size, Tag};
use App\Livewire\Forms\ProductManagementForm;

// TODO: Usar un parent component AdminComponent.
#[Layout('layouts.admin')]
#[Title('Product Management')]
final class ProductCreateManagement extends Component
{
    public ProductManagementForm $form;

    public function updatingFormName(string $value): void
    {
        $this->form->slug = str()->slug($value);
    }

    public function save()
    {
        /*
        if (! auth()->user()->can(PermissionsEnum::CREATE_PRODUCTS->value)) {
            abort(403);
        }
        */
        $this->authorize('create', $this->form->product);
        $this->form->validate();
        try {
            DB::transaction(function () {
                // TODO: Guardar imagenes relacionadas al producto.
                $product = Product::create($this->form->store());
                $this->form->reset();
                Flux::toast(
                    heading: __('Product Created'),
                    text: __('Product has been created successfully.'),
                    variant: 'success',
                );
                $this->redirect(route('admin.products.edit', $product), navigate: true);
            });
        } catch (Exception $e) {
            report($e);
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while saving product: ') . $e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.products.create', [
            'categories' => Category::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
            'sizes' => Size::orderBy('name')->get(),
            'tagsList' => Tag::all(),
            'statusList' => ProductsStatusEnum::cases(),
        ]);
    }
}
