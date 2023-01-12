<x-guest-layout>
    <div class="auth-forms">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="title">
                EasyWrite
            </div>

            <div class="logo-block">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500 logo" />
            </div>

            <!-- Name -->
            <div class="row">
                <div class="validate-input col-md-6">
                    <div class="wrap-input md:mr-1">
                        <x-text-input id="fname" class="block mt-1 w-full input" type="text" name="fname" :value="old('fname')" required/>
                        <span class="label" data-placeholder="First Name"></span>
                    </div>
                    <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                </div>
                <div class="validate-input col-md-6">
                    <div class="wrap-input md:ml-1">
                        <x-text-input id="lname" class="block mt-1 w-full input" type="text" name="lname" :value="old('lname')" required/>
                        <span class="label" data-placeholder="Last Name"></span>
                    </div>
                    <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                </div>
            </div>

            <!-- Email Address -->
            <div class="validate-input">
                <div class="wrap-input">
                    <x-text-input id="email" class="block mt-1 w-full input" type="email" name="email" :value="old('email')" required/>
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

            <!-- Confirm Password -->
            <div class="validate-input">
                <div class="wrap-input">
                    <x-text-input id="password_confirmation" class="block mt-1 w-full input" type="password" name="password_confirmation" required/>
                    <span class="label" data-placeholder="Confirm Password"></span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="forget-password-link">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>

            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <div class="btn-gradiant"></div>
                <x-primary-button class="submit-btn">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
