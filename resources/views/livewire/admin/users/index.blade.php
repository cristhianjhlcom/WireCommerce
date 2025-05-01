<div class="space-y-4">
    <flux:heading>{{ __('Users Management') }}</flux:heading>
    <flux:text class="mt-2">{{ __('Manage users of the system.') }}</flux:text>
    <flux:separator />

    <div class="flex flex-col space-y-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- NOTE: Barra de búsqueda -->
            <div class="flex-1 max-w-md">
                <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="{{ __('Search') }}..." />
            </div>
            <flux:button.group>
                <!-- NOTE: Botón de filtros -->
                <flux:button wire:click="$toggle('showFilters')" icon="funnel">
                    {{ __('Filters') }}
                </flux:button>
                <!-- NOTE: Botón para mostrar/ocultar eliminados -->
                <flux:button wire:click="toggleTrashed" icon="eye">
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
            <flux:table.column sortable :sorted="$sortBy === 'role'" :direction="$sortDirection" wire:click="sort('role')">{{ __('Role') }}</flux:table.column>
            <flux:table.column>{{ __('Email') }}</flux:table.column>
            <flux:table.column>{{ __('Document') }}</flux:table.column>
            <flux:table.column>{{ __('Phone') }}</flux:table.column>
            <flux:table.column>{{ __('Date') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($users as $user)
                <flux:table.row :key="$user->id">
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
                        <flux:dropdown position="bottom" align="end">
                            <flux:button variant="ghost" icon="ellipsis-horizontal"></flux:button>
                            <flux:menu>
                                <flux:menu.item icon="eye" href="{{ route('admin.users.show', $user) }}">
                                    {{ __('View') }}
                                </flux:menu.item>
                                <flux:menu.item icon="pencil" href="{{ route('admin.users.edit', $user) }}">
                                    {{ __('Edit') }}
                                </flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger" wire:confirm.prevent="{{ __('Are you sure you want to delete this user?') }}" wire:click="delete({{ $user }})">
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
