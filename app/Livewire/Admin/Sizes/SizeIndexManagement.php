<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sizes;

use App\Enums\PermissionsEnum;
use App\Models\Size;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(('layouts.admin'))]
final class SizeIndexManagement extends Component
{
    public function delete(Size $size)
    {
        if (! auth()->user()->can(PermissionsEnum::DELETE_SIZES->value)) {
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('You cannot delete sizes.'),
                variant: 'error',
            );
        }

        $size->delete();

        Flux::toast(
            heading: __('Size deleted'),
            text: __('Size deleted successfully.'),
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.admin.sizes.index')
            ->with([
                'sizes' => Size::latest()
                    ->paginate(16),
            ]);
    }
}
