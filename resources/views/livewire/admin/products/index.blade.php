<div class="space-y-4">
  <flux:heading>{{ __('Products Management') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Manage Products of the system.') }}</flux:text>
  <flux:separator />

  <div class="flex flex-col space-y-4">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <!-- NOTE: Barra de búsqueda -->
      <div class="max-w-md flex-1">
        <flux:input
          icon="magnifying-glass"
          placeholder="{{ __('Search') }}..."
          wire:model.live.debounce.300ms="search"
        />
      </div>
      <flux:button.group>
        <!-- NOTE: Botón de filtros -->
        <flux:button icon="funnel" wire:click="$toggle('showFilters')">
          {{ __('Filters') }}
        </flux:button>
        <!-- NOTE: Botón para mostrar/ocultar eliminados -->
        <flux:button icon="eye" wire:click="toggleTrashed">
          {{ __('Show/Hide Trashed') }}
        </flux:button>
        <flux:button
          href="{{ route('admin.products.create') }}"
          icon="plus"
          wire:navigate
        >
          {{ __('Add Product') }}
        </flux:button>
      </flux:button.group>
    </div>
    {{-- NOTE: Table to list all users. --}}
    <flux:table :paginate="$variants">
      <flux:table.columns>
        <flux:table.column>{{ __('SKU') }}</flux:table.column>
        <flux:table.column>{{ __('Name') }}</flux:table.column>
        <flux:table.column>{{ __('Category') }}</flux:table.column>
        <flux:table.column>{{ __('Price') }}</flux:table.column>
        <flux:table.column>{{ __('Sale Price') }}</flux:table.column>
        <flux:table.column>{{ __('Status') }}</flux:table.column>
        <flux:table.column>{{ __('Inventory') }}</flux:table.column>
        <flux:table.column>{{ __('Date') }}</flux:table.column>
      </flux:table.columns>

      <flux:table.rows>
        @foreach ($variants as $variant)
          <flux:table.row key="{{ $variant->id }}">
            <flux:table.cell class="flex items-center gap-3">
              <flux:avatar
                alt="{{ $variant->product->name }}"
                circle
                src="{{ $variant->image }}"
              />
              <div class="flex flex-col items-start gap-y-1">
                <h4>{{ $variant->sku }}</h4>
              </div>
            </flux:table.cell>
            <flux:table.cell>
              {{ $variant->product->name }}
            </flux:table.cell>
            <flux:table.cell>
              {{ $variant->product->category->name }}
            </flux:table.cell>
            <flux:table.cell>
              {{ $variant->getFormattedPrice() }}
            </flux:table.cell>
            <flux:table.cell>
              {{ $variant->getFormattedSalePrice() ?? __('No Discount') }}
            </flux:table.cell>
            <flux:table.cell>
              <flux:badge color="{{ $variant->product->status->color() }}">
                {{ $variant->product->status->label() }}
              </flux:badge>
            </flux:table.cell>
            <flux:table.cell>
              <flux:badge color="{{ $variant->status->color() }}">
                {{ $variant->status->label() }}
              </flux:badge>
            </flux:table.cell>
            <flux:table.cell>{{ $variant->product->createdAtHuman() }}</flux:table.cell>
            <flux:table.cell>
              <flux:dropdown align="end" position="bottom">
                <flux:button icon="ellipsis-horizontal" variant="ghost"></flux:button>
                <flux:menu>
                  <flux:navmenu.item
                    href="{{ route('admin.products.edit', ['product' => $variant->product]) }}"
                    icon="pencil"
                    wire:navigate
                  >
                    {{ __('Edit') }}
                  </flux:navmenu.item>
                  <flux:menu.item
                    icon="archive-box"
                    variant="danger"
                    wire:click="delete({{ $variant->product }})"
                    wire:confirm.prevent="{{ __('Are you sure you want to delete this user?') }}"
                  >
                    {{ __('Archive') }}
                  </flux:menu.item>
                </flux:menu>
              </flux:dropdown>
            </flux:table.cell>
          </flux:table.row>
        @endforeach
      </flux:table.rows>
    </flux:table>
  </div>
