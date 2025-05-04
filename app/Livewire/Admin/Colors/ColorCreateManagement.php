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

#[Layout(('layouts.admin'))]
class ColorCreateManagement extends Component
{
    #[Validate]
    public string $name = '';

    public string $hex = '';

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
            Color::create([
                'name' => $this->name,
                'hex' => $this->hex,
            ]);

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
        return view('livewire.admin.colors.create');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'hex' => 'required|string|max:255',
        ];
    }
}
