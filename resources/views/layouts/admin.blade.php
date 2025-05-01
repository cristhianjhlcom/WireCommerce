<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? __('Adminitration') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @fluxAppearance
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable
        class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
            class="px-2 dark:hidden" />
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
            class="px-2 hidden dark:flex" />
        <flux:input as="button" variant="filled" placeholder="{{ __('Search') }}..." icon="magnifying-glass" />
        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('home.index') }}">{{ __('Home') }}</flux:navlist.item>
            <flux:navlist.item icon="user" badge="{{ $usersCount }}" href="{{ route('admin.users.index') }}">{{ __('Users') }}</flux:navlist.item>
        </flux:navlist>
        <flux:spacer />
        @auth
            <flux:dropdown position="top" align="start" class="max-lg:hidden">
                <flux:profile name="{{ auth()->user()->profile->full_name }}" />

                <flux:menu>
                    <flux:menu.item icon="cog-6-tooth" href="#">{{ __('Settings') }}</flux:menu.item>
                    <flux:menu.item icon="information-circle" href="#">{{ __('Help') }}</flux:menu.item>
                    <flux:menu.separator />
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <flux:menu.item icon="arrow-right-start-on-rectangle" type="submit">{{ __('Logout') }}</flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth
    </flux:sidebar>
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" alignt="start">
            <flux:profile avatar:name="{{ auth()->user()->profile->full_name }}" />
            <flux:menu>
                <flux:menu.item icon="cog-6-tooth" href="#">{{ __('Settings') }}</flux:menu.item>
                <flux:menu.item icon="information-circle" href="#">{{ __('Help') }}</flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle">{{ __('Logout') }}</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
    <flux:main>
        {{ $slot }}
    </flux:main>
    <flux:toast />
    @fluxScripts
</body>

</html>
