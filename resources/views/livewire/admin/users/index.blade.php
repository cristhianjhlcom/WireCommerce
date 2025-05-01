<div>
    {{-- NOTE: Dialog to create new user --}}
    <flux:modal.trigger name="create-user">
        <flux:button icon="plus" variant="primary">{{ __('Add User') }}</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-user" class="md:w-xl">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:input wire:model="first_name" name="first_name" label="{{ __('First Name') }}" placeholder="John Doe" />
            <flux:input wire:model="last_name" name="last_name" label="{{ __('Last Name') }}" placeholder="Doe" />
            <flux:input
                wire:model="email"
                name="email"
                label="{{ __('Email') }}"
                placeholder="john.doe@example.com"
            />
            <flux:input wire:model="phone_number" name="phone_number" label="{{ __('Phone Number') }}" placeholder="9999999999" />
            <flux:field>
                <flux:label>{{ __('Document Type') }}</flux:label>
                <flux:select wire:model="document_type" placeholder="{{ __('Choose Document Type') }}...">
                    @foreach (\App\Enums\DocumentsTypeEnum::cases() as $type)
                        <flux:select.option value="{{ $type->value }}">{{ $type->label() }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="document_type" />
            </flux:field>
            <flux:input wire:model="document_number" name="document_number" label="{{ __('Document Number') }}"
                placeholder="41222333" />
            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
        </form>
    </flux:modal>

    {{-- NOTE: Table to list all users. --}}
    <flux:table :paginate="$users">
        <flux:table.columns>
            <flux:table.column>{{ __('Customer') }}</flux:table.column>
            <flux:table.column>{{ __('Role') }}</flux:table.column>
            <flux:table.column>{{ __('Email') }}</flux:table.column>
            <flux:table.column>{{ __('Document') }}</flux:table.column>
            <flux:table.column>{{ __('Phone') }}</flux:table.column>
            <flux:table.column>{{ __('Date') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($users as $user)
                <flux:table.row :key="$user->id">
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar name="{{ $user->profile->full_name }}" />
                        {{ $user->profile->full_name }}
                    </flux:table.cell>
                    <flux:table.cell>
                        @foreach ($user->getRoles() as $role)
                            <flux:badge color="{{ $role->color() }}">{{ $role->label() }}</flux:badge>
                        @endforeach
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $user->email }}
                    </flux:table.cell>
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:badge>{{ $user->profile->documentTypeLabel() }}</flux:badge>
                        {{ $user->profile->document_number ?? '-' }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $user->profile->phone_number ?? '-' }}
                    </flux:table.cell>
                    <flux:table.cell>{{ $user->createdAtHuman() }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown position="bottom" align="end">
                            <flux:button variant="ghost" icon="ellipsis-horizontal"></flux:button>
                            <flux:menu>
                                <flux:menu.item
                                    icon="trash"
                                    variant="danger"
                                    wire:confirm.prevent="{{ __('Are you sure you want to delete this user?') }}"
                                    wire:click="delete({{ $user }})"
                                >{{ __('Delete') }}</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
