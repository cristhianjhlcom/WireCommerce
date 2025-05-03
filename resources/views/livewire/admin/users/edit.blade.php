<div class="space-y-4">
  <flux:heading>{{ __('Edit User') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Update user information.') }}</flux:text>
  <flux:separator />
  <form class="w-[95%] max-w-xl space-y-4" wire:submit.prevent="save">
    <flux:field>
      <flux:label>{{ __('Email') }}</flux:label>
      <flux:input
        readonly
        value="{{ $user->email }}"
        variant="filled"
      />
      <flux:error name="email" />
      <flux:description>{{ __('This email cannot be changed.') }}</flux:description>
    </flux:field>
    <flux:separator />
    <div class="grid grid-cols-2 gap-4">
      <flux:input
        label="{{ __('First Name') }}"
        name="first_name"
        placeholder="John"
        wire:model="first_name"
      />
      <flux:input
        label="{{ __('Last Name') }}"
        name="last_name"
        placeholder="Doe"
        wire:model="last_name"
      />
    </div>
    <flux:input
      label="{{ __('Phone Number') }}"
      mask="999-999-999"
      name="phone_number"
      placeholder="999-999-999"
      wire:model="phone_number"
    />
    <div class="grid grid-cols-2 gap-4">
      <flux:field>
        <flux:label>{{ __('Document Type') }}</flux:label>
        <flux:select placeholder="{{ __('Choose Document Type') }}..." wire:model="document_type">
          @foreach ($documentsType as $type)
            <flux:select.option value="{{ $type->value }}">{{ $type->label() }}</flux:select.option>
          @endforeach
        </flux:select>
        <flux:error name="document_type" />
      </flux:field>
      <flux:input
        label="{{ __('Document Number') }}"
        name="document_number"
        placeholder="41222333"
        wire:model="document_number"
      />
    </div>
    <flux:separator />
    <flux:field>
      <flux:label>{{ __('Role') }}</flux:label>
      <flux:select placeholder="{{ __('Choose Role') }}..." wire:model="role">
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
