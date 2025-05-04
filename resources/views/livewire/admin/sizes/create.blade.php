<div class="space-y-4">
  <flux:heading>{{ __('Sizes Management') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Fill the form below to create a new size.') }}</flux:text>
  <flux:separator />
  <form class="w-[95%] max-w-md space-y-4" wire:submit.prevent="save">
    <flux:input
      label="{{ __('Name') }}"
      name="name"
      placeholder="{{ __('Size Name') }}"
      wire:model="name"
    />
    <div>
      <flux:button type="submit" variant="primary">{{ __('Create') }}</flux:button>
    </div>
</div>
