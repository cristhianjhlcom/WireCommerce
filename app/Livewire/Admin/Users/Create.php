<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Enums\DocumentTypes;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin')]
final class Create extends Component
{
    #[Validate]
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone_number = '';

    public DocumentTypes $document_type;

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

    public function save()
    {
        // TODO: Add authorization with admin user.
        $this->validate();

        $user = User::create([
            'email' => $this->email,
            'password' => Hash::make('password'),
        ]);

        $user->profile()->create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'document_type' => $this->document_type,
            'document_number' => $this->document_number,
        ]);

        // TODO: Find the way to refresh the table after the user is created.
        Flux::modal('create-user')->close();
        Flux::toast(__('User created successfully.'));
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.admin.users.create');
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
