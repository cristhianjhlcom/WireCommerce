<x-layout.auth>
  <flux:card class="w-[95%] max-w-[450px] space-y-6">
    <div>
      <flux:heading size="lg">{{ __('Create a new account') }}</flux:heading>
      <flux:text class="mt-2">{{ __('Register a new account to start your journey with us.') }}</flux:text>
    </div>

    <form
      action="{{ route('register.store') }}"
      class="space-y-6"
      method="POST"
    >
      @csrf
      <flux:input
        label="{{ __('Email') }}"
        name="email"
        placeholder="{{ __('Your email address') }}"
        type="email"
      />
      <flux:input
        label="{{ __('Password') }}"
        name="password"
        placeholder="********"
        type="password"
      />
      <flux:input
        label="{{ __('Password Confirmation') }}"
        name="password_confirmation"
        placeholder="********"
        type="password"
      />

      <div class="space-y-2">
        <flux:button
          class="w-full"
          type="submit"
          variant="primary"
        >{{ __('Register') }}</flux:button>
        <flux:button class="w-full" variant="ghost">{{ __('Already have an account?') }}</flux:button>
      </div>
    </form>
  </flux:card>
</x-layout.auth>
