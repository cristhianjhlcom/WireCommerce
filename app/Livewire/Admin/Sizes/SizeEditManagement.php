<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sizes;

use App\Enums\PermissionsEnum;
use App\Models\Size;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout(('layouts.admin'))]
final class SizeEditManagement extends Component
{
    public ?Size $size = null;

    #[Validate]
    public string $name = '';

    public function mount(Size $size)
    {
        // TODO: Add services class to handle all those logic.
        if (! auth()->user()->can(PermissionsEnum::EDIT_SIZES->value)) {
            abort(403);
        }

        $this->size = $size;
        $this->name = $size->name;
    }

    public function save()
    {
        // TODO: Add services class to handle all those logic.
        if (! auth()->user()->can(PermissionsEnum::CREATE_SIZES->value)) {
            abort(403);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            Size::updateOrCreate(
                ['id' => $this->size?->id],
                [
                    'name' => Str::upper($this->name),
                ]
            );

            DB::commit();

            $this->reset();

            $this->redirect(route('admin.sizes.index'), navigate: true);
        } catch (Exception $e) {
            DB::rollBack();

            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while creating size: ').$e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.sizes.edit');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
