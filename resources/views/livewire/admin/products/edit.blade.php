<div class="space-y-4">
  <div class="flex items-center justify-between">
    <div>
      <flux:heading>{{ __('Update Product') }}</flux:heading>
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
              placeholder="{{ __('Gold Ring') }}"
              wire:model.live='form.name'
            />
            <flux:error name="form.name" />
          </flux:field>
          <flux:input.group>
            <flux:input.group.prefix>{{ env('APP_URL') }}/products/</flux:input.group.prefix>
            <flux:input
              disabled
              placeholder="{{ __('gold-ring') }}"
              wire:model.live='form.slug'
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
            <flux:errorname="form.images" />
          </flux:field>
        </flux:card>

        {{-- Variaciones --}}
        <flux:card class="space-y-4">
          <div class="flex items-center justify-between gap-x-4">
            <div>
              <flux:heading>{{ __('Variants Combinations') }}</flux:heading>
              <flux:text class="mt-2">
                {{ __('Select the combinations you want to sell and set the price for each one.') }}
              </flux:text>
            </div>
            <flux:modal.trigger name="add-variant">
              <flux:button icon:trailing="plus">
                {{ __('Add New Variant') }}
              </flux:button>
            </flux:modal.trigger>
            <flux:modal class="md:w-[500px]" name="add-variant">
              <div class="space-y-4">
                <div>
                  <flux:heading size="lg">{{ __('Add New Variant') }}</flux:heading>
                  <flux:text class="mt-2">
                    {{ __('Select the combinations you want to sell and set the price for each one.') }}
                  </flux:text>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                  <flux:input
                    label="SKU"
                    placeholder="Unique SKU"
                    wire:model="form.variant_sku"
                  />
                  <flux:field>
                    <flux:label>
                      {{ __('Status') }}
                    </flux:label>
                    <flux:select placeholder="{{ __('Select Status') }}" wire:model="form.variant_status">
                      @foreach ($productStatus as $status)
                        <flux:select.option value="{{ $status->value }}" wire:key="{{ $status->value }}">
                          {{ $status->label() }}
                        </flux:select.option>
                      @endforeach
                    </flux:select>
                    <flux:error name="form.variant_status" />
                  </flux:field>
                </div>

                <flux:field>
                  <flux:label>
                    {{ __('Price') }}
                  </flux:label>
                  <flux:input
                    placeholder="S/. 99.99"
                    type="text"
                    wire:model="form.variant_price"
                  />
                  <flux:error name="form.variant_price" />
                </flux:field>
                <flux:field>
                  <flux:label>
                    {{ __('Sale Price') }}
                  </flux:label>
                  <flux:input
                    placeholder="S/. 59.99"
                    type="text"
                    wire:model="form.variant_sale_price"
                  />
                  <flux:error name="form.variant_sale_price" />
                  <flux:description>
                    Deja este campo vacío para no incluir en el precio con descuento.
                  </flux:description>
                </flux:field>
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                  <flux:field>
                    <flux:label>
                      {{ __('Color') }}
                    </flux:label>
                    <flux:select placeholder="{{ __('Select Color') }}" wire:model="form.variant_color">
                      @foreach ($colors as $color)
                        <flux:select.option value="{{ $color->id }}">
                          {{ $color->name }}
                        </flux:select.option>
                      @endforeach
                    </flux:select>
                    <flux:error name="form.variant_color" />
                  </flux:field>
                  <flux:field>
                    <flux:label>
                      {{ __('Size') }}
                    </flux:label>
                    <flux:select placeholder="{{ __('Select Size') }}" wire:model="form.variant_size">
                      @foreach ($sizes as $size)
                        <flux:select.option value="{{ $size->id }}">
                          {{ $size->name }}
                        </flux:select.option>
                      @endforeach
                    </flux:select>
                    <flux:error name="form.variant_size" />
                  </flux:field>
                </div>
                <flux:input
                  label="Variant Image"
                  type="file"
                  wire:model="form.variant_image"
                />
                <div class="flex">
                  <flux:spacer />
                  <flux:button
                    type="button"
                    variant="primary"
                    wire:click="addVariant"
                  >
                    {{ __('Create Variant') }}
                  </flux:button>
                </div>
              </div>
            </flux:modal>
          </div>
          <flux:table>
            <flux:table.columns>
              <flux:table.column>{{ __('Variant') }}</flux:table.column>
              <flux:table.column>{{ __('Status') }}</flux:table.column>
              <flux:table.column>{{ __('Price') }}</flux:table.column>
              <flux:table.column>{{ __('Sale Price') }}</flux:table.column>
              <flux:table.column>{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
              @forelse ($product->variants as $variant)
                <flux:table.row wire:key="variant-{{ $variant->id }}">
                  <flux:table.cell>{{ $variant->sku }}</flux:table.cell>
                  <flux:table.cell>
                    {{ $variant->color?->name }} / {{ $variant->size?->name }}
                  </flux:table.cell>
                  <flux:table.cell>
                    <flux:badge
                      color="green"
                      inset="top bottom"
                      size="sm"
                    >
                      {{ $variant->status->label() }}
                    </flux:badge>
                  </flux:table.cell>
                  <flux:table.cell variant="strong">
                    {{ $variant->getFormattedPrice() }}
                  </flux:table.cell>
                  <flux:table.cell variant="strong">
                    {{ $variant->getFormattedSalePrice() ?? '---' }}
                  </flux:table.cell>
                  <flux:table.cell>
                    <flux:dropdown align="end" position="bottom">
                      <flux:button icon="ellipsis-horizontal" variant="ghost"></flux:button>
                      <flux:menu>
                        {{-- <flux:navmenu.item
                          href="{{ route('admin.products.edit', ['product' => $variant->product]) }}"
                          icon="pencil"
                          wire:navigate
                        >
                          {{ __('Edit') }}
                        </flux:navmenu.item> --}}
                        <flux:menu.item
                          icon="trash"
                          variant="danger"
                          wire:click="deleteVariant({{ $variant->id }})"
                          wire:confirm.prevent="{{ __('Are you sure you want to delete this user?') }}"
                        >
                          {{ __('Delete') }}
                        </flux:menu.item>
                      </flux:menu>
                    </flux:dropdown>
                  </flux:table.cell>
                </flux:table.row>
              @empty
                <flux:table.row>
                  <flux:table.cell class="text-center" colspan="5">
                    {{ __('No Records') }}
                  </flux:table.cell>
                </flux:table.row>
              @endforelse
            </flux:table.rows>
          </flux:table>
        </flux:card>
      </div>

      {{-- Second Section --}}
      <div class="w-full space-y-4 md:w-1/3">
        <flux:card class="space-y-4">
          <flux:field>
            <flux:label>{{ __('Status') }}</flux:label>
            <flux:select placeholder="{{ __('Select Status') }}" wire:model="form.status">
              @foreach ($productStatus as $status)
                @php
                  $isDisabled = $status === \App\Enums\ProductsStatusEnum::ACTIVE && !$product->variants->count();
                @endphp
                <flux:select.option :disabled="$isDisabled" value="{{ $status->value }}">
                  {{ $status->label() }}
                </flux:select.option>
              @endforeach
            </flux:select>
            <flux:errorname="form.status" />
            @if (!$product->variants->count())
              <flux:description class="text-yellow-600">
                {{ __('You need to add at least one variant to activate this product.') }}
              </flux:description>
            @endif
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
              @foreach ($productTags as $tag)
                <flux:select.option selected="{{ in_array($tag->id, $form->tags) }}" value="{{ $tag->id }}">
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
        {{ __('Update Changes') }}
      </flux:button>
    </div>
  </form>
</div>
