<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Enums\CurrenciesCodeEnum;
use App\Enums\PermissionsEnum;
use App\Enums\ProductsStatusEnum;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Tag;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Money\Currencies;

// TODO: Usar un parent component AdminComponent.
#[Layout('layouts.admin')]
#[Title('Product Management')]
final class ProductCreateManagement extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|unique:products,slug')]
    public string $slug = '';

    #[Validate('nullable|string|max:255')]
    public ?string $description = null;

    #[Validate('required|exists:categories,id')]
    public $category_id = null;

    #[Validate('nullable|string|max:255')]
    public ?string $seo_title = null;

    #[Validate('nullable|string|max:255')]
    public ?string $seo_description = null;

    public string $variant_sku = '';
    public string $variant_color_id = '';
    public string $variant_size_id = '';
    public string $variant_price = '';
    public string $variant_sale_price = '';
    public CurrenciesCodeEnum $variant_currency_code = CurrenciesCodeEnum::PEN;
    public ProductsStatusEnum $variant_statu = ProductsStatusEnum::ACTIVE;
    public ?string $variant_image = null;
    public array $variants = [
        [
            'sku' => 'AF001',
            'status' => ProductsStatusEnum::ACTIVE,
            'price' => 9999,
            'sale_price' => 5999,
            'color_id' => 1,
            'size_id' => 1,
            'currency_code' => CurrenciesCodeEnum::PEN,
            'image' => null,
        ],
        [
            'sku' => 'AF002',
            'status' => ProductsStatusEnum::ACTIVE,
            'price' => 9999,
            'sale_price' => 0,
            'color_id' => 1,
            'size_id' => 1,
            'currency_code' => CurrenciesCodeEnum::PEN,
            'image' => null,
        ],
    ];

    public ?string $image = null;

    public mixed $colors;
    public mixed $sizes;
    public mixed $categories;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'variants' => 'required|array|min:1',
            'variants.*.sku' => 'required|string|unique:product_variants,sku',
            'variants.*.price' => 'required|integer|min:1',
            'variants.*.sale_price' => 'nullable|integer|min:1',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.size_id' => 'nullable|exists:sizes,id',
            'variants.*.image' => 'nullable|file|max:1024',
        ];
    }

    public function addVariant()
    {
        $this->variants[] = [
            'sku' => $this->variant_sku,
            'price' => $this->variant_price,
            'sale_price' => (int) $this->variant_sale_price,
            'color_id' => (int) $this->variant_color_id,
            'size_id' => $this->variant_size_id,
            'currency_code' => $this->variant_currency_code,
            'status' => $this->variant_statu,
            'image' => $this->variant_image,
        ];

        Flux::modal('add-variant')->close();
    }

    public function mount()
    {
        $this->colors = Color::all();
        $this->sizes = Size::all();
        $this->categories = Category::all();
    }


    public function updating($property, $value)
    {
        if ($property === 'name') {
            $this->slug = str()->slug($value);
        }
    }

    public function save()
    {
        if (! auth()->user()->can(PermissionsEnum::CREATE_CATEGORIES->value)) {
            abort(403);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            Product::create([
                'name' => str()->title($this->name),
                'slug' => $this->slug,
                'description' => $this->description,
                'image' => $this->image,
            ]);

            DB::commit();

            $this->reset();

            $this->redirect(route('admin.products.index'), navigate: true);
        } catch (Exception $e) {
            DB::rollBack();

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
            'tags' => Tag::all(),
            'variants' => $this->variants,
            'status' => ProductsStatusEnum::cases(),
        ]);
    }
}
