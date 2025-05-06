<div class="space-y-4">
  <flux:heading>{{ __('Categories Management') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Fill the form below to create a new category.') }}</flux:text>
  <flux:separator />
  <form class="w-[95%] max-w-md space-y-4" wire:submit.prevent="save">
    <flux:input
      label="{{ __('Name') }}"
      placeholder="{{ __('Gold Ring') }}"
      wire:model.live="name"
    />
    <flux:input
      label="{{ __('Slug') }}"
      placeholder="{{ __('gold-ring') }}"
      wire:model.live="slug"
    />
    <flux:input
      accept="image/*"
      label="{{ __('Image') }}"
      type="file"
      wire:model.lazy="image"
    />
    <flux:editor
      description="{{ __('A brief description of the category.') }}"
      label="{{ __('Description') }}"
      wire:model="description"
    />
    <div class="flex">
      <flux:button type="submit" variant="primary">{{ __('Save Changes') }}</flux:button>
    </div>
</div>
