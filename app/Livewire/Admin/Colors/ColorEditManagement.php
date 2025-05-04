<?php

namespace App\Livewire\Admin\Colors;

use App\Enums\PermissionsEnum;
use App\Models\Color;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

#[Layout(('layouts.admin'))]
class ColorEditManagement extends Component
{
    public ?Color $color = null;

    #[Validate]
    public string $name = '';

    public string $hex = '';

    public function mount(Color $color)
    {
        // TODO: Add services class to handle all those logic.
        if (! auth()->user()->can(PermissionsEnum::EDIT_COLORS->value)) {
            Flux::toast(
                heading: __('Access Denied'),
                text: __('You cannot edit colors.'),
                variant: 'error',
            );

            return redirect()->route('admin.colors.index');
        }

        $this->color = $color;
        $this->name = $color->name;
        $this->hex = $color->hex;
    }

    public function save()
    {
        // TODO: Add services class to handle all those logic.
        if (! auth()->user()->can(PermissionsEnum::CREATE_COLORS->value)) {
            Flux::toast(
                heading: __('Access Denied'),
                text: __('You cannot create colors.'),
                variant: 'error',
            );

            return redirect()->route('admin.colors.index');
        }

        $this->validate();

        try {
            Color::updateOrCreate(
                ['id' => $this->color?->id],
                [
                    'name' => $this->name,
                    'hex' => $this->hex,
                ]
            );

            DB::commit();

            $this->reset();

            Flux::toast(
                heading: __('Color Created'),
                text: __('Color created successfully.'),
                variant: 'success',
            );

            return redirect()->route('admin.colors.index');
        } catch (Exception $e) {
            DB::rollBack();

            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while creating color: ') . $e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.colors.edit');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'hex' => 'required|string|max:255',
        ];
    }
}
