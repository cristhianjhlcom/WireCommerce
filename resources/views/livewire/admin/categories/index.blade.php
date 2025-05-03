<div class="space-y-4">
  <flux:heading>{{ __('Categories Management') }}</flux:heading>
  <flux:text class="mt-2">{{ __('Manage categories of the system.') }}</flux:text>
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
        <flux:modal.trigger name="create-category">
          <flux:button icon="plus">
            {{ __('Add Category') }}
          </flux:button>
        </flux:modal.trigger>
      </flux:button.group>
    </div>
    <flux:modal
      @cancel="refreshForm"
      @close="refreshForm"
      class="md:w-2/3 lg:w-1/2"
      name="create-category"
    >
      <form class="space-y-6" wire:submit.prevent="save">
        <div>
          <flux:heading size="lg">{{ __('Update Category') }}</flux:heading>
          <flux:text class="mt-2">{{ __('Update Current Category.') }}</flux:text>
        </div>
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
          <flux:spacer />
          <flux:button type="submit" variant="primary">{{ __('Save Changes') }}</flux:button>
        </div>
      </form>
    </flux:modal>

    {{-- NOTE: Table to list all users. --}}
    <flux:table :paginate="$categories">
      <flux:table.columns>
        <flux:table.column>{{ __('Name') }}</flux:table.column>
        <flux:table.column>{{ __('Description') }}</flux:table.column>
        <flux:table.column>{{ __('Date') }}</flux:table.column>
      </flux:table.columns>

      <flux:table.rows>
        @foreach ($categories as $category)
          <flux:table.row :key="$category - > id">
            <flux:table.cell class="flex items-center gap-3">
              {{ $category->name }}
            </flux:table.cell>
            <flux:table.cell class="max-w-3xs">
              <flux:text class="text-wrap">{!! $category->description ?? '-' !!}</flux:text>
            </flux:table.cell>
            <flux:table.cell>{{ $category->createdAtHuman() }}</flux:table.cell>
            <flux:table.cell>
              <flux:dropdown align="end" position="bottom">
                <flux:button icon="ellipsis-horizontal" variant="ghost"></flux:button>
                <flux:menu>
                  <flux:navmenu.item icon="pencil" wire:click='edit({{ $category }})'>
                    {{ __('Edit') }}
                  </flux:navmenu.item>
                  <flux:menu.item
                    icon="archive-box"
                    variant="danger"
                    wire:click="delete({{ $category }})"
                    wire:confirm.prevent="{{ __('Are you sure you want to delete this user?') }}"
                  >
                    {{ __('Archive') }}
                  </flux:menu.item>
                </flux:menu>
              </flux:dropdown>
              <flux:modal
                @cancel="refreshForm"
                @close="refreshForm"
                class="md:w-2/3 lg:w-1/2"
                name='{{ "edit-category-{$category->id}" }}'
              >
                <form class="space-y-6" wire:submit.prevent="save">
                  <div>
                    <flux:heading size="lg">{{ __('Create Category') }}</flux:heading>
                    <flux:text class="mt-2">{{ __('Create a new category.') }}</flux:text>
                  </div>
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
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">{{ __('Save Changes') }}</flux:button>
                  </div>
                </form>
              </flux:modal>
            </flux:table.cell>
          </flux:table.row>
        @endforeach
      </flux:table.rows>
    </flux:table>
  </div>
