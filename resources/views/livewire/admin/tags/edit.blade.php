<div class="space-y-4">
  <flux:heading>{{ __('Tags Management') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Fill the form below to create a new tag.') }}</flux:text>
  <flux:separator />
  <form class="w-[95%] max-w-md space-y-4" wire:submit.prevent="save">
    <flux:input
      label="{{ __('Name') }}"
      name="name"
      placeholder="Hot Sale"
      wire:model.live="name"
    />
    <flux:input
      label="{{ __('Slug') }}"
      placeholder="{{ __('hot-sale') }}"
      readonly
      variant="filled"
      wire:model.live="slug"
    />
    <flux:field>
      <flux:label>{{ __('Icon') }}</flux:label>
      <flux:select placeholder="{{ __('Choose Icon') }}..." wire:model="icon">
        @foreach ($availableIcons as $icon)
          <flux:select.option value="{{ $icon }}" wire:key="{{ $icon }}">
            {{ $icon }}
          </flux:select.option>
        @endforeach
      </flux:select>
    </flux:field>
    <div>
      <flux:button type="submit" variant="primary">{{ __('Update') }}</flux:button>
    </div>
</div>
