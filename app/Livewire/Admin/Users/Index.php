<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Enums\DocumentsTypeEnum;
use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
final class Index extends Component
{
    use WithPagination;

    public string $sortBy = 'role';
    public string $sortDirection = 'desc';

    #[Validate]
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone_number = '';

    public DocumentsTypeEnum $document_type = DocumentsTypeEnum::DNI;

    public string $document_number = '';

    public bool $isOpen = false;

    protected $messages = [
        'first_name.required' => 'El nombre es obligatorio',
        'first_name.max' => 'El nombre no debe exceder los 255 caracteres',
        'last_name.required' => 'El apellido es obligatorio',
        'email.required' => 'El correo es obligatorio',
        'email.email' => 'El correo debe ser válido',
        'email.unique' => 'Este correo ya está registrado',
        'phone_number.required' => 'El teléfono es obligatorio',
        'document_type.required' => 'El tipo de documento es obligatorio',
        'document_type.enum' => 'El tipo de documento seleccionado no es válido',
        'document_number.required' => 'El número de documento es obligatorio',
    ];

    protected $validationAttributes = [
        'first_name' => 'nombre',
        'last_name' => 'apellido',
        'email' => 'correo electrónico',
        'phone_number' => 'teléfono',
        'document_type' => 'tipo de documento',
        'document_number' => 'número de documento',
    ];

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function save()
    {
        if (! auth()->user()->can(PermissionsEnum::CREATE_USERS->value)) {
            abort(403);
        }

        $this->validate();

        $user = User::create([
            'email' => $this->email,
            'password' => bcrypt('password'),
        ]);

        $user->profile()->create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'document_type' => $this->document_type,
            'document_number' => $this->document_number,
        ]);

        $user->assignRole(RolesEnum::USER->value);

        Flux::modal('create-user')->close();
        Flux::toast(__('User created successfully.'));
    }

    public function delete(User $user)
    {
        if (! auth()->user()->can(PermissionsEnum::DELETE_USERS->value)) {
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('User deleted successfully.'),
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
        return \App\Models\User::with('profile')
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
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

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                // Rule::unique('users')->ignore($this->user),
            ],
            'phone_number' => 'required|string|max:255',
            'document_type' => 'required',
            'document_number' => 'required|string|max:255',
        ];
    }
}
