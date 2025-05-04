<div class="space-y-4">
  <flux:heading>{{ __('Colors Management') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Fill the form below to create a new color.') }}</flux:text>
  <flux:separator />
  <form class="w-[95%] max-w-md space-y-4" wire:submit.prevent="save">
    <flux:input
      label="{{ __('Name') }}"
      name="name"
      placeholder="{{ __('Color Name') }}"
      wire:model="name"
    />
    <flux:input
      label="{{ __('Hexadecimal') }}"
      placeholder="{{ __('#ff00ff') }}"
      wire:model="hex"
    />
    <div>
      <flux:button type="submit" variant="primary">{{ __('Create') }}</flux:button>
    </div>
</div>
