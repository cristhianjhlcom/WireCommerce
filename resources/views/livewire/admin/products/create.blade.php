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

  <form class="space-y-4" wire:submit.prevent="save">
    <div class="flex flex-col gap-x-4 md:flex-row md:items-start md:justify-between">
      {{-- First Section --}}
      <div class="w-full space-y-4 md:w-2/3">
        <flux:card class="space-y-4">
          <flux:field>
            <flux:input
              autocomplete="off"
              id="name"
              placeholder="{{ __('Product Name') }}"
              type="text"
              wire:model.live='form.name'
            />
            <flux:error name="form.name" />
          </flux:field>
          <flux:input.group>
            <flux:input.group.prefix>{{ env('APP_URL') }}/products/</flux:input.group.prefix>
            <flux:input
              id="slug"
              placeholder="{{ __('gold-ring') }}"
              readonly
              wire:model.defer='form.slug'
            />
          </flux:input.group>
          <flux:editor
            description="{{ __('Description must be at most 500 characters.') }}"
            label="{{ __('Description') }}"
            wire:model="form.description"
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
              multiple
              type="file"
              wire:model.lazy="form.images"
            />
            <flux:errorname="form.image" />
          </flux:field>
        </flux:card>
      </div>

      {{-- Second Section --}}
      <div class="w-full space-y-4 md:w-1/3">
        <flux:card class="space-y-4">
          <flux:field>
            <flux:label>{{ __('Status') }}</flux:label>
            <flux:select
              disabled
              placeholder="{{ __('Select Status') }}"
              wire:model="form.status"
            >
              @foreach ($statusList as $statu)
                <flux:select.option value="{{ $statu->value }}">
                  {{ $statu->label() }}
                </flux:select.option>
              @endforeach
            </flux:select>
            <flux:errorname="form.status" />
          </flux:field>
        </flux:card>
        <flux:card class="space-y-4">
          <flux:field>
            <flux:label>{{ __('Category') }}</flux:label>
            <flux:description>
              {{ __('Categories group products together. You can define a category on the categories pages.') }}
            </flux:description>
            <flux:select placeholder="{{ __('Select Category') }}" wire:model="form.category">
              @foreach ($categories as $category)
                <flux:select.option value="{{ $category->id }}">
                  {{ $category->name }}
                </flux:select.option>
              @endforeach
            </flux:select>
            <flux:error name="form.category" />
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
              wire:model="form.tags"
            >
              @foreach ($tagsList as $tag)
                <flux:select.option value="{{ $tag->id }}">
                  {{ $tag->name }}
                </flux:select.option>
              @endforeach
            </flux:select>
            <flux:error name="form.tags" />
          </flux:field>
        </flux:card>
        <flux:card class="space-y-4">
          <flux:input
            label="{{ __('Seo Title') }}"
            name="form.seo_title"
            placeholder="Pretty Title 📦"
            type="text"
            wire:model="form.seo_title"
          />
          <flux:textarea
            label="{{ __('Seo Description') }}"
            name="form.seo_description"
            placeholder="Descripción para los buscadores como Google, Bing, etc."
            rows="2"
            wire:model="form.seo_description"
          />
        </flux:card>
      </div>
    </div>
    <div class="flex">
      <flux:button type="submit" variant="primary">
        {{ __('Save Changes') }}
      </flux:button>
    </div>
  </form>
</div>
