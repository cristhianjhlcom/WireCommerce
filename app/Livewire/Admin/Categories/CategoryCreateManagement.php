<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Enums\PermissionsEnum;
use App\Models\Category;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

// TODO: Usar un parent component AdminComponent.
#[Layout('layouts.admin')]
#[Title('Category Management')]
final class CategoryCreateManagement extends Component
{
    #[Validate]
    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public ?string $image = null;

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
            Category::create([
                'name' => str()->title($this->name),
                'slug' => $this->slug,
                'description' => $this->description,
                'image' => $this->image,
            ]);

            DB::commit();

            $this->reset();

            $this->redirect(route('admin.categories.index'), navigate: true);
        } catch (Exception $e) {
            DB::rollBack();

            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while saving category: ').$e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.categories.create');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|min:3|unique:categories,slug',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
