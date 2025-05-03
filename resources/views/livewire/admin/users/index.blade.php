<div class="space-y-4">
  <flux:heading>{{ __('Users Management') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Manage users of the system.') }}</flux:text>
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
        <flux:button href="{{ route('admin.users.create') }}" icon="plus">
          {{ __('Add User') }}
        </flux:button>
      </flux:button.group>
    </div>

    {{-- NOTE: Table to list all users. --}}
    <flux:table :paginate="$users">
      <flux:table.columns>
        <flux:table.column>{{ __('Customer') }}</flux:table.column>
        <flux:table.column
          :direction="$sortDirection"
          :sorted="$sortBy === 'role'"
          sortable
          wire:click="sort('role')"
        >{{ __('Role') }}</flux:table.column>
        <flux:table.column>{{ __('Email') }}</flux:table.column>
        <flux:table.column>{{ __('Document') }}</flux:table.column>
        <flux:table.column>{{ __('Phone') }}</flux:table.column>
        <flux:table.column>{{ __('Date') }}</flux:table.column>
      </flux:table.columns>

      <flux:table.rows>
        @foreach ($users as $user)
          <flux:table.row :key="$user - > id">
            <flux:table.cell class="flex items-center gap-3">
              <flux:avatar name="{{ $user->profile->full_name }}" />
              {{ $user->profile->full_name }}
            </flux:table.cell>
            <flux:table.cell>
              @foreach ($user->getRoles() as $role)
                <flux:badge color="{{ $role->color() }}">{{ $role->label() }}</flux:badge>
              @endforeach
            </flux:table.cell>
            <flux:table.cell>
              {{ $user->email }}
            </flux:table.cell>
            <flux:table.cell class="flex items-center gap-3">
              <flux:badge>{{ $user->profile->documentTypeLabel() }}</flux:badge>
              {{ $user->profile->document_number ?? '-' }}
            </flux:table.cell>
            <flux:table.cell>
              {{ $user->profile->phone_number ?? '-' }}
            </flux:table.cell>
            <flux:table.cell>{{ $user->createdAtHuman() }}</flux:table.cell>
            <flux:table.cell>
              <flux:dropdown align="end" position="bottom">
                <flux:button icon="ellipsis-horizontal" variant="ghost"></flux:button>
                <flux:menu>
                  <flux:menu.item href="{{ route('admin.users.show', $user) }}" icon="eye">
                    {{ __('View') }}
                  </flux:menu.item>
                  <flux:menu.item href="{{ route('admin.users.edit', $user) }}" icon="pencil">
                    {{ __('Edit') }}
                  </flux:menu.item>
                  <flux:menu.item
                    icon="trash"
                    variant="danger"
                    wire:click="delete({{ $user }})"
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
