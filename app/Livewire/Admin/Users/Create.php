<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Enums\DocumentsTypeEnum;
use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
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

    public DocumentsTypeEnum $document_type = DocumentsTypeEnum::DNI;

    public string $document_number = '';

    public RolesEnum $role = RolesEnum::USER;

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
        'role.required' => 'El rol es obligatorio',
        'role.enum' => 'El rol seleccionado no es válido',
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
        if (! auth()->user()->can(PermissionsEnum::CREATE_USERS->value)) {
            Flux::toast(
                heading: __('Access Denied'),
                text: __('You cannot create users.'),
                variant: 'error',
            );

            return redirect()->route('admin.users.index');
        }

        $this->validate();

        try {
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

            DB::commit();

            $this->reset();

            Flux::toast(
                heading: __('User Created'),
                text: __('User created successfully.'),
                variant: 'success',
            );

            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            DB::rollBack();
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('Error while updating user: ').$e->getMessage(),
                variant: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.users.create', [
            'documentsType' => DocumentsTypeEnum::cases(),
            'roles' => RolesEnum::cases(),
        ]);
    }

    protected function rules()
    {
        return [
            'email' => 'required|string|email|max:255|unique:users,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'document_type' => 'required',
            'document_number' => 'required|string|max:255',
            'role' => 'required',
        ];
    }
}
