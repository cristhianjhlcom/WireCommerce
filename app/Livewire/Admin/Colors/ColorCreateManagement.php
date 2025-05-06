<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Colors;

use App\Enums\PermissionsEnum;
use App\Models\Color;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout(('layouts.admin'))]
final class ColorCreateManagement extends Component
{
    #[Validate]
    public string $name = '';

    public string $hex = '';

    public function save()
    {
        // TODO: Add services class to handle all those logic.
        if (! auth()->user()->can(PermissionsEnum::CREATE_COLORS->value)) {
            abort(403);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            Color::create([
                'name' => Str::title($this->name),
                'hex' => $this->hex,
            ]);

            DB::commit();

            $this->reset();

            $this->redirect(route('admin.colors.index'), navigate: true);
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
