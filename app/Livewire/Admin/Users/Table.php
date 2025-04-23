<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
final class Table extends Component
{
    use \Livewire\WithPagination;

    public function render()
    {
        return view('livewire.admin.users.table')->with([
            'users' => User::with('profile')->paginate(10),
        ]);
    }
}
