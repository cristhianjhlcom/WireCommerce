<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Enums\PermissionsEnum;
use App\Models\Category;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Category Management')]
final class CategoryIndexManagement extends Component
{
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
}
