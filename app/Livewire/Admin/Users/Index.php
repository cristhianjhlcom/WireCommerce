<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
final class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.users.index');
    }
}
