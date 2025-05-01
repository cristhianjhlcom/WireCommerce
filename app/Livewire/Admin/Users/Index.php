<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Enums\PermissionsEnum;
use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
final class Index extends Component
{
    use WithPagination;

    public string $sortBy = 'role';

    public string $sortDirection = 'desc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function delete(User $user)
    {
        if (! auth()->user()->can(PermissionsEnum::DELETE_USERS->value)) {
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('You cannot delete users.'),
                variant: 'error',
            );
        }

        $user->delete();

        Flux::toast(
            heading: __('User deleted'),
            text: __('User deleted successfully.'),
            variant: 'success',
        );
    }

    public function users()
    {
        return User::with('profile')
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.users.index')->with([
            'users' => User::with('profile')
                ->latest()
                ->paginate(10),
        ]);
    }
}
