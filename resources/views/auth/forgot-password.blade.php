<x-guest-layout>
    <div class="logo-block text-center">
        <h3 class="text-center my-2">ARLO+</h3>
    </div>

    <div class="auth-forms">
        <h4 class="mb-3 forgot-pwd-title">Forgot your password?</h4>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4 pwd-text-line">
                {{ __('Enter your email address and we will send you a link to reset your password.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 pwd-text-line" :status="session('status')" />

            <!-- Email Address -->
            <div class="validate-input">
                <div class="wrap-input">
                    <label for="Email" class="label-text">Email</label>
                    <x-text-input id="email" class="block mt-1 w-full input" type="email" 
                    name="email" placeholder="Your email address" autofocus=true required/>
                    <!-- <span class="label" data-placeholder="Email"></span> -->
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 error-msg" />
            </div>

            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <x-primary-button class="submit-btn">
                    {{ __('Send password reset link') }}
                </x-primary-button>
            </div>
            <div class="text-center mt-1 register-block">
                <a class="underline hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                href="{{ route('login') }}">
                    {{ __('Back to Login') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
