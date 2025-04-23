<flux:table :paginate="$users">
    <flux:table.columns>
        <flux:table.column>{{ __('Customer') }}</flux:table.column>
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
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
