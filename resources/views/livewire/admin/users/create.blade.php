<div>
    <flux:modal.trigger name="create-user">
        <flux:button icon="plus" variant="primary">{{ __('Add User') }}</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-user" class="md:w-xl">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:input wire:model="first_name" name="first_name" label="{{ __('First Name') }}" placeholder="John Doe" />
            <flux:input wire:model="last_name" name="last_name" label="{{ __('Last Name') }}" placeholder="Doe" />
            <flux:input wire:model="email" name="email" label="{{ __('Email') }}" placeholder="john.doe@example.com" />
            <flux:input wire:model="phone_number" name="phone_number" label="{{ __('Phone Number') }}" placeholder="9999999999" />
            <flux:field>
                <flux:label>{{ __('Document Type') }}</flux:label>
                <flux:select wire:model="document_type" placeholder="Choose Document Type...">
                    @foreach (\App\Enums\DocumentTypes::cases() as $type)
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
</div>
