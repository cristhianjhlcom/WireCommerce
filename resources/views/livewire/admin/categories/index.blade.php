<div class="space-y-4">
    <flux:heading>{{ __('Categories Management') }}</flux:heading>
    <flux:text class="mt-2">{{ __('Manage categories of the system.') }}</flux:text>
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
                <flux:button href="/" icon="plus">
                    {{ __('Add Category') }}
                </flux:button>
            </flux:button.group>
        </div>

    {{-- NOTE: Table to list all users. --}}
    <flux:table :paginate="$categories">
        <flux:table.columns>
            <flux:table.column>{{ __('Name') }}</flux:table.column>
            <flux:table.column>{{ __('Description') }}</flux:table.column>
            <flux:table.column>{{ __('Date') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($categories as $category)
                <flux:table.row :key="$category->id">
                    <flux:table.cell class="flex items-center gap-3">
                        {{ $category->name }}
                    </flux:table.cell>
                    <flux:table.cell class="max-w-3xs">
                        <flux:text class="text-wrap">{{ $category->description ?? '-' }}</flux:text>
                    </flux:table.cell>
                    <flux:table.cell>{{ $category->createdAtHuman() }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown position="bottom" align="end">
                            <flux:button variant="ghost" icon="ellipsis-horizontal"></flux:button>
                            <flux:menu>
                                <flux:menu.item icon="pencil" href="/">
                                    {{ __('Edit') }}
                                </flux:menu.item>
                                <flux:menu.item icon="archive-box" variant="danger" wire:confirm.prevent="{{ __('Are you sure you want to delete this user?') }}" wire:click="delete({{ $category }})">
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
