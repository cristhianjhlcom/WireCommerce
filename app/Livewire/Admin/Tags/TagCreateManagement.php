<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Tags;

use App\Enums\PermissionsEnum;
use App\Models\Tag;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout(('layouts.admin'))]
final class TagCreateManagement extends Component
{
    public array $availableIcons = ['🔥', '⚡', '⭐', '🏷️', '😎'];

    #[Validate]
    public string $name = '';

    public string $slug = '';

    public string $icon = '🔥';

    public function updating($property, $value)
    {
        if ($property === 'name') {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        // TODO: Add services class to handle all those logic.
        if (! auth()->user()->can(PermissionsEnum::CREATE_TAGS->value)) {
            abort(403);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            Tag::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'icon' => $this->icon,
            ]);

            DB::commit();

            $this->reset();

            $this->redirect(route('admin.tags.index'), navigate: true);
        } catch (Exception $e) {
            DB::rollBack();

            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while creating tag: ').$e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.tags.create');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tags,slug',
            'icon' => ['nullable', Rule::in(array_merge($this->availableIcons, [null]))],
        ];
    }
}
