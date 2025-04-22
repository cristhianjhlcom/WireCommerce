<?php

declare(strict_types=1);

namespace App\Livewire\Public\Catalog;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
final class Index extends Component
{
    public function render()
    {
        return view('livewire.public.catalog.index');
    }
}
