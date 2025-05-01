<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Enums\PermissionsEnum;
use App\Models\Category;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin')]
final class Index extends Component
{
    #[Validate]
    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public ?string $image = null;

    public function refreshForm()
    {
        $this->reset();
    }

    public function updating($property, $value)
    {
        if ($property === 'name') {
            $this->slug = Str::slug($value);
        }
    }

    public function edit(Category $category)
    {
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->image = $category->image;

        Flux::modal('edit-category-'.$category->id)->show();
    }

    public function save()
    {
        if (! auth()->user()->can(PermissionsEnum::CREATE_CATEGORIES->value)) {
            Flux::toast(
                heading: __('Access Denied'),
                text: __('You cannot create categories.'),
                variant: 'error',
            );

            return redirect()->route('admin.categories.index');
        }

        $this->validate();

        try {
            Category::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'image' => $this->image,
            ]);

            DB::commit();

            $this->reset();

            Flux::toast(
                heading: __('Category Created'),
                text: __('Category created successfully.'),
                variant: 'success',
            );

            Flux::modal('create-category')->close();
        } catch (Exception $e) {
            DB::rollBack();

            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while creating category: ').$e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function delete(Category $category)
    {
        if (! auth()->user()->can(PermissionsEnum::DELETE_CATEGORIES->value)) {
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('You cannot delete categories.'),
                variant: 'error',
            );
        }

        $category->delete();

        Flux::toast(
            heading: __('Category deleted'),
            text: __('Category deleted successfully.'),
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.admin.categories.index', [
            'categories' => Category::latest()
                ->paginate(16),
        ]);
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
