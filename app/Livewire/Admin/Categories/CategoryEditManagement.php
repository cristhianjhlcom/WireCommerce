<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Enums\PermissionsEnum;
use App\Models\Category;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout(('layouts.admin'))]
#[Title('Category Management')]
final class CategoryEditManagement extends Component
{
    public Category $category;

    #[Validate]
    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public ?string $image = null;

    public function mount(Category $category)
    {
        // TODO: Add services class to handle all those logic.
        if (! auth()->user()->can(PermissionsEnum::EDIT_CATEGORIES->value)) {
            abort(403);
        }

        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->image = $category->image;
        $this->category = $category;
    }

    public function updating($property, $value)
    {
        if ($property === 'name') {
            $this->slug = str()->slug($value);
        }
    }

    public function save()
    {
        if (! auth()->user()->can(PermissionsEnum::UPDATE_CATEGORIES->value)) {
            abort(403);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            $this->category->update([
                'name' => str()->title($this->name),
                'slug' => $this->slug,
                'description' => $this->description,
                'image' => $this->image,
            ]);

            DB::commit();

            $this->reset();

            $this->redirect(route('admin.categories.index'), navigate: true);
            // NOTE: Add custom ExceptionMessage.
        } catch (Exception $e) {
            DB::rollBack();

            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while updating category: ').$e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.categories.edit');
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
