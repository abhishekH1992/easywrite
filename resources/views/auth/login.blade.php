<x-guest-layout>
    <div class="auth-forms">
        <form method="POST" action="{{ route('login') }}">

            <div class="logo-block">
                <img src="/assets/images/EasyWrite.svg">
            </div>

            @csrf

            <!-- Email Address -->
            <div class="validate-input">
                <div class="wrap-input">
                    <x-text-input id="email" class="block mt-1 w-full input" type="email" name="email" required/>
                    <span class="label" data-placeholder="Email"></span>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="validate-input">
                <div class="wrap-input">
                    <x-text-input id="password" class="block mt-1 w-full input" type="password" name="password" required autocomplete="current-password" />
                    <span class="label" data-placeholder="Password"></span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="forget-password-link">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <div class="btn-gradiant"></div>
                <x-primary-button class="submit-btn">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <div class="text-center mt-3 register-block">
                Don’t have an account? 
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                    {{ __('Sign Up') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
