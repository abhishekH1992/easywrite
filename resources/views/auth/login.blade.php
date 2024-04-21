<x-guest-layout>
    <div class="logo-block text-center">
        <img src="/assets/images/arlo-logo.svg">
    </div>
    <div class="auth-forms">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Address -->
            <div class="validate-input">
                <div class="wrap-input">
                    <label for="Email" class="label-text">Email</label>
                    <x-text-input id="email" class="block mt-1 w-full input" type="email" 
                    name="email" placeholder="Your email address" autofocus=true required/>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 error-msg" />
            </div>

            <!-- Password -->
            <div class="validate-input pwd-field">
                <div class="wrap-input">
                    <label for="password" class="label-text">Password</label>
                    <x-text-input id="password" class="block mt-1 w-full input" placeholder="Your password"
                    type="password" name="password" required autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 error-msg" />
            </div>

            <div class="forget-password-link">
                @if (Route::has('password.request'))
                    <a class="underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <x-primary-button class="submit-btn">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <div class="text-center mt-1 register-block">
                Don’t have an account? 
                <a class="underline font-bold text-gray-600 hover:text-gray-900 rounded-md 
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                href="{{ route('register') }}">
                    {{ __('Sign Up') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
