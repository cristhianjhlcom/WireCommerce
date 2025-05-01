<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Enums\PermissionsEnum;
use App\Models\Category;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin')]
final class Index extends Component
{
    public ?Category $category = null;

    #[Validate]
    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public ?string $image = null;

    public function refreshForm()
    {
        $this->category = null;
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
        if (! auth()->user()->can(PermissionsEnum::EDIT_CATEGORIES->value)) {
            Flux::toast(
                heading: __('Access Denied'),
                text: __('You cannot edit categories.'),
                variant: 'error',
            );

            Flux::modal("edit-category-{$category->id}")->close();
        }

        $this->category = $category;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->image = $category->image;

        Flux::modal("edit-category-{$category->id}")->show();
    }

    public function save()
    {
        if (! auth()->user()->can(PermissionsEnum::CREATE_CATEGORIES->value)) {
            Flux::toast(
                heading: __('Access Denied'),
                text: __('You cannot manage categories.'),
                variant: 'error',
            );

            if ($this->category) {
                Flux::modal("edit-category-{$this->category->id}")->close();
            } else {
                Flux::modal('create-category')->close();
            }
        }

        $this->validate();

        try {
            Category::updateOrCreate(
                ['id' => $this->category?->id],
                [
                    'name' => Str::title($this->name),
                    'slug' => $this->slug,
                    'description' => $this->description,
                    'image' => $this->image,
                ]
            );

            DB::commit();

            $this->reset();

            Flux::toast(
                heading: __('Category Saved'),
                text: __('Category saved successfully.'),
                variant: 'success',
            );

            if ($this->category) {
                Flux::modal("edit-category-{$this->category->id}")->close();
            } else {
                Flux::modal('create-category')->close();
            }
        } catch (Exception $e) {
            DB::rollBack();

            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while saving category: ').$e->getMessage(),
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
            'slug' => [
                'required',
                'min:3',
                Rule::unique('categories', 'slug')->ignore($this->category?->id),
            ],
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
