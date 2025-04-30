<x-layout.auth>
    <flux:card class="space-y-6 w-[95%] max-w-[450px]">
        <div>
            <flux:heading size="lg">{{ __('Login') }}</flux:heading>
            <flux:text class="mt-2">{{ __('Login to your account to start your journey with us.') }}</flux:text>
        </div>

        <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
            @csrf
            <flux:input label="{{ __('Email') }}" name="email" type="email" placeholder="{{ __('Your email address') }}" />
            <flux:input label="{{ __('Password') }}" name="password" type="password" placeholder="********" />

            <div class="space-y-2">
                <flux:button type="submit" variant="primary" class="w-full">{{ __('Login') }}</flux:button>
                <flux:button variant="ghost" class="w-full">{{ __('Need an account?') }}</flux:button>
            </div>
        </form>
    </flux:card>
</x-layout.auth>
