<x-guest-layout>
    <div class="auth-forms">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div class="logo-block">
                <img src="/assets/images/EasyWrite.svg">
            </div>

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="validate-input">
                <div class="wrap-input">
                    <x-text-input id="email" class="block mt-1 w-full input" type="email" name="email" :value="old('email', $request->email)" required/>
                    <span class="label" data-placeholder="Email"></span>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="validate-input">
                <div class="wrap-input">
                    <x-text-input id="email" class="block mt-1 w-full input" type="password" name="password" required/>
                    <span class="label" data-placeholder="Password"></span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="validate-input">
                <div class="wrap-input">
                    <x-text-input id="email" class="block mt-1 w-full input" type="password" name="password_confirmation" required/>
                    <span class="label" data-placeholder="Confirm Password"></span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <x-primary-button class="submit-btn">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
