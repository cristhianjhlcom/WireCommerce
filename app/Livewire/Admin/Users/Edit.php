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
final class Edit extends Component
{
    public User $user;

    public string $email = '';

    #[Validate()]
    public string $first_name = '';

    public string $last_name = '';

    public string $phone_number = '';

    public DocumentsTypeEnum $document_type = DocumentsTypeEnum::DNI;

    public string $document_number = '';

    public RolesEnum $role = RolesEnum::USER;

    protected $messages = [
        'first_name.required' => 'El nombre es obligatorio',
        'first_name.max' => 'El nombre no debe exceder los 255 caracteres',
        'last_name.required' => 'El apellido es obligatorio',
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
        'phone_number' => 'teléfono',
        'document_type' => 'tipo de documento',
        'document_number' => 'número de documento',
    ];

    public function mount(User $user)
    {
        if (! auth()->user()->can(PermissionsEnum::EDIT_USERS->value)) {
            Flux::toast(
                heading: __('Access Denied'),
                text: __('You cannot edit users.'),
                variant: 'error',
            );

            return redirect()->route('admin.users.index');
        }

        $this->user = $user;
        $this->email = $user->email;

        if ($user->profile) {
            $this->first_name = $user->profile->first_name ?? '';
            $this->last_name = $user->profile->last_name ?? '';
            $this->phone_number = $user->profile->phone_number ?? '';
            $this->document_type = $user->profile->document_type ?? DocumentsTypeEnum::DNI;
            $this->document_number = $user->profile->document_number ?? '';
        }

        $roles = $user->getRoles();

        $this->role = $roles->isNotEmpty() ? $user->getRoles()->first() : RolesEnum::USER;
    }

    public function save()
    {
        if (! auth()->user()->can(PermissionsEnum::EDIT_USERS->value)) {
            Flux::toast(
                heading: __('Something went wrong'),
                text: __('You cannot edit users.'),
                variant: 'error',
            );

            return;
        }

        $this->validate();

        DB::beginTransaction();
        try {
            $this->user->profile()->updateOrCreate(
                [],
                [
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'phone_number' => $this->phone_number,
                    'document_type' => $this->document_type,
                    'document_number' => $this->document_number,
                ]
            );

            $currentRoles = $this->user->getRoles();

            if ($currentRoles->isEmpty() || $currentRoles->first() !== $this->role) {
                $this->user->syncRoles([$this->role->value]);
            }

            DB::commit();

            Flux::toast(
                heading: __('User Updated'),
                text: __('User updated successfully.'),
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
        return view('livewire.admin.users.edit', [
            'documentsType' => DocumentsTypeEnum::cases(),
            'roles' => RolesEnum::cases(),
        ]);
    }

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'document_type' => 'required',
            'document_number' => 'required|string|max:255',
            'role' => 'required',
        ];
    }
}
