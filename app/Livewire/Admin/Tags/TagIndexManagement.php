<?php

namespace App\Livewire\Admin\Tags;

use App\Enums\PermissionsEnum;
use App\Models\Tag;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(('layouts.admin'))]
class TagIndexManagement extends Component
{
    public function delete(Tag $tag)
    {
        if (! auth()->user()->can(PermissionsEnum::DELETE_TAGS->value)) {
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('You cannot delete tags.'),
                variant: 'error',
            );
        }

        $tag->delete();

        Flux::toast(
            heading: __('Tag deleted'),
            text: __('Tag deleted successfully.'),
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.admin.tags.index')
            ->with([
                'tags' => Tag::latest()
                    ->paginate(16),
            ]);
    }
}
