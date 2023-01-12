<x-guest-layout>
    <div class="auth-forms">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="title">
                EasyWrite
            </div>

            <div class="logo-block">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500 logo" />
            </div>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Email Address -->
            <div class="validate-input">
                <div class="wrap-input">
                    <x-text-input id="email" class="block mt-1 w-full input" type="email" name="email" required/>
                    <span class="label" data-placeholder="Email"></span>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <div class="btn-gradiant"></div>
                <x-primary-button class="submit-btn">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
