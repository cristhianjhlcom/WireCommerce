<div class="space-y-4">
    <flux:heading>{{ __('Edit User') }}</flux:heading>
    <flux:text class="mt-2">{{ __('Update user information.') }}</flux:text>
    <flux:separator />
    <form wire:submit.prevent="save" class="w-[95%] max-w-xl space-y-4">
        <flux:field>
            <flux:label>{{ __('Email') }}</flux:label>
            <flux:input value="{{ $user->email }}" readonly variant="filled" />
            <flux:error name="email" />
            <flux:description>{{ __('This email cannot be changed.') }}</flux:description>
        </flux:field>
        <flux:separator />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="first_name" name="first_name" label="{{ __('First Name') }}" placeholder="John" />
            <flux:input wire:model="last_name" name="last_name" label="{{ __('Last Name') }}" placeholder="Doe" />
        </div>
        <flux:input wire:model="phone_number" name="phone_number" mask="999-999-999" label="{{ __('Phone Number') }}" placeholder="999-999-999" />
        <div class="grid grid-cols-2 gap-4">
            <flux:field>
                <flux:label>{{ __('Document Type') }}</flux:label>
                <flux:select wire:model="document_type" placeholder="{{ __('Choose Document Type') }}...">
                    @foreach ($documentsType as $type)
                        <flux:select.option value="{{ $type->value }}">{{ $type->label() }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="document_type" />
            </flux:field>
            <flux:input wire:model="document_number" name="document_number" label="{{ __('Document Number') }}" placeholder="41222333" />
        </div>
        <flux:separator />
        <flux:field>
            <flux:label>{{ __('Role') }}</flux:label>
            <flux:select wire:model="role" placeholder="{{ __('Choose Role') }}...">
                @foreach ($roles as $role)
                    <flux:select.option value="{{ $role->value }}">{{ $role->label() }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="role" />
        </flux:field>
        <div class="flex space-x-4">
            <flux:button type="submit" variant="primary">{{ __('Update') }}</flux:button>
            <flux:button href="{{ route('admin.users.index') }}">{{ __('Cancel') }}</flux:button>
        </div>
    </form>
</div>
