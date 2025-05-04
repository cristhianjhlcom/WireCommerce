<div class="space-y-4">
  <flux:heading>{{ __('Sizes Management') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Manage sizes of the system.') }}</flux:text>
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
        <flux:button href="{{ route('admin.sizes.create') }}" icon="plus">
          {{ __('Add Size') }}
        </flux:button>
      </flux:button.group>
    </div>

    {{-- NOTE: Table to list all records. --}}
    <flux:table :paginate="$sizes">
      <flux:table.columns>
        <flux:table.column>{{ __('Name') }}</flux:table.column>
        <flux:table.column>{{ __('Created At') }}</flux:table.column>
        <flux:table.column>{{ __('Updated At') }}</flux:table.column>
      </flux:table.columns>

      <flux:table.rows>
        @foreach ($sizes as $size)
          <flux:table.row key="{{ $size->id }}">
            <flux:table.cell class="flex items-center gap-3">
              <div class="flex flex-col gap-y-2">
                <flux:text>{{ $size->name }}</flux:text>
              </div>
            </flux:table.cell>
            <flux:table.cell>{{ $size->createdAtHuman() }}</flux:table.cell>
            <flux:table.cell>{{ $size->updatedAtHuman() }}</flux:table.cell>
            <flux:table.cell>
              <flux:dropdown align="end" position="bottom">
                <flux:button icon="ellipsis-horizontal" variant="ghost"></flux:button>
                <flux:menu>
                  <flux:menu.item href="{{ route('admin.sizes.edit', $size) }}" icon="pencil">
                    {{ __('Edit') }}
                  </flux:menu.item>
                  <flux:menu.item
                    icon="trash"
                    variant="danger"
                    wire:click="delete({{ $size }})"
                    wire:confirm.prevent="{{ __('Are you sure you want to delete this record?') }}"
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
