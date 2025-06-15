<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use Exception;
use Flux\Flux;
use Livewire\Component;
use App\Enums\ProductsStatusEnum;
use Livewire\Attributes\{Layout, Title};
use App\Models\{Category, Color, Size, Tag};
use App\Livewire\Forms\ProductManagementForm;
use App\Services\Admin\ProductManagementServices;

// TODO: Usar un parent component AdminComponent.
#[Layout('layouts.admin')]
#[Title('Product Management')]
final class ProductCreateManagement extends Component
{
    public ProductManagementForm $form;
    public ProductManagementServices $services;

    public mixed $colors;
    public mixed $sizes;
    public mixed $categories;

    public function mount(ProductManagementServices $services)
    {
        $this->services = $services;
        $this->colors = Color::all();
        $this->sizes = Size::all();
        $this->categories = Category::all();
    }


    public function updating($property, $value)
    {
        if ($property === 'form.name') {
            $this->form->slug = str()->slug($value);
        }
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
            // TODO: Guardar imagenes relacionadas al producto.
            $product = $this->services->create($this->form);

            Flux::toast(
                heading: __('Product Created'),
                text: __('Product has been created successfully.'),
                variant: 'success',
            );

            $this->redirect(route('admin.products.edit', $product), navigate: true);
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
            'tagsList' => Tag::all(),
            // 'variants' => $this->variants,
            'statusList' => ProductsStatusEnum::cases(),
        ]);
    }
}
