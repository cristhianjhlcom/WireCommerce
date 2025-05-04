<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Colors;

use App\Enums\PermissionsEnum;
use App\Models\Color;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(('layouts.admin'))]
final class ColorIndexManagement extends Component
{
    public function delete(Color $color)
    {
        if (! auth()->user()->can(PermissionsEnum::DELETE_COLORS->value)) {
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('You cannot delete colors.'),
                variant: 'error',
            );
        }

        $color->delete();

        Flux::toast(
            heading: __('Color deleted'),
            text: __('Color deleted successfully.'),
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.admin.colors.index')
            ->with([
                'colors' => Color::latest()
                    ->paginate(16),
            ]);
    }
}
