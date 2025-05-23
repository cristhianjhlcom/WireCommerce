<div class="space-y-4">
  <div class="flex items-center justify-between">
    <div>
      <flux:heading>{{ __('Create Product') }}</flux:heading>
      <flux:text class="mt-2">{{ __('Change this product details') }}</flux:text>
    </div>
    <div>
      <flux:button icon:trailing="arrow-top-right-on-square">
        {{ __('View this product') }}
      </flux:button>
    </div>
  </div>
  <flux:separator />
  <form class="space-y-4" wire:submit.prevent="save">
    <div class="flex items-start justify-between gap-x-4">
      {{-- First Section --}}
      <div class="space-y-4 md:w-2/3">
        <flux:card class="space-y-4">
          <flux:field>
            <flux:input placeholder="{{ __('Gold Ring') }}" wire:model.live='name' />
            <flux:error name="name" />
          </flux:field>
          <flux:input.group>
            <flux:input.group.prefix>{{ env('APP_URL') }}/products/</flux:input.group.prefix>
            <flux:input placeholder="{{ __('gold-ring') }}" wire:model.live='slug' />
          </flux:input.group>
          <flux:editor
            description="{{ __('Description must be at most 500 characters.') }}"
            label="{{ __('Description') }}"
            wire:model="description"
          />
        </flux:card>

        <flux:card class="space-y-4">
          <flux:field>
            <flux:label>{{ __('Media') }}</flux:label>
            <flux:description>
              {{ __('Formats: PNG, JPG, WebP, AVIF - Max dimensions: 1200x1200 (1:1) - Max size: 4.5 MB') }}
            </flux:description>
            <flux:input
              accept="image/*"
              type="file"
              wire:model.lazy="image"
            />
            <flux:errorname="image" />
          </flux:field>
        </flux:card>

        <flux:card class="space-y-4">
          <h1>Variants</h1>
        </flux:card>
      </div>

      {{-- Second Section --}}
      <div class="space-y-4 md:w-1/3">
        <flux:card class="space-y-4">
          <flux:field>
            <flux:label>{{ __('Status') }}</flux:label>
            <flux:select placeholder="{{ __('Select Status') }}" wire:model="status">
              @foreach (App\Enums\ProductsStatusEnum::cases() as $key => $value)
                <flux:select.option value="{{ $key }}">{{ $value->label() }}</flux:select.option>
              @endforeach
            </flux:select>
            <flux:errorname="status" />
          </flux:field>
        </flux:card>
        <flux:card class="space-y-4">
          <flux:field>
            <flux:label>{{ __('Category') }}</flux:label>
            <flux:description>
              {{ __('Categories group products together. You can define a category on the categories pages.') }}
            </flux:description>
            <flux:select placeholder="{{ __('Select Category') }}" wire:model="category">
              @foreach ($categories as $category)
                <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
              @endforeach
            </flux:select>
            <flux:error name="category" />
          </flux:field>
          <flux:field>
            <flux:label badge="{{ __('Optional') }}">{{ __('Tags') }}</flux:label>
            <flux:description>
              {{ __('Tags for special promotions') }}
            </flux:description>
            <flux:select
              multiple
              placeholder="{{ __('Select Tag') }}"
              variant="listbox"
              wire:model="tags"
            >
              @foreach ($tags as $tag)
                <flux:select.option value="{{ $tag->id }}">{{ $tag->name }}</flux:select.option>
              @endforeach
            </flux:select>
            <flux:error name="tags" />
          </flux:field>
        </flux:card>
      </div>
    </div>
    <div class="flex">
      <flux:button type="submit" variant="primary">{{ __('Save Changes') }}</flux:button>
    </div>
  </form>
</div>
