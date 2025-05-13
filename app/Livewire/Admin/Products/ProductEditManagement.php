<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Enums\PermissionsEnum;
use App\Models\Product;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout(('layouts.admin'))]
#[Title('Product Management')]
final class ProductEditManagement extends Component
{
    public Product $product;

    #[Validate]
    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public ?string $image = null;

    public function mount(Product $product)
    {
        // TODO: Add services class to handle all those logic.
        if (! auth()->user()->can(PermissionsEnum::EDIT_PRODUCTS->value)) {
            abort(403);
        }

        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->image = $product->image;
        $this->product = $product;
    }

    public function updating($property, $value)
    {
        if ($property === 'name') {
            $this->slug = str()->slug($value);
        }
    }

    public function save()
    {
        if (! auth()->user()->can(PermissionsEnum::UPDATE_PRODUCTS->value)) {
            abort(403);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            $this->product->update([
                'name' => str()->title($this->name),
                'slug' => $this->slug,
                'description' => $this->description,
                'image' => $this->image,
            ]);

            DB::commit();

            $this->reset();

            $this->redirect(route('admin.products.index'), navigate: true);
            // NOTE: Add custom ExceptionMessage.
        } catch (Exception $e) {
            DB::rollBack();

            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while updating product: ') . $e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.products.edit');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'min:3',
                Rule::unique('products', 'slug')->ignore($this->product?->id),
            ],
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
