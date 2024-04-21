<x-guest-layout>
    <div class="logo-block text-center">
        <img src="/assets/images/arlo-logo.svg">
    </div>

    <div class="auth-forms">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="validate-input">
                <div class="wrap-input">
                    <label for="Email" class="label-text">Email</label>
                    <x-text-input id="email" class="block mt-1 w-full input" type="email" 
                    name="email" :value="old('email', $request->email)" required/>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 error-msg" />
            </div>

            <!-- Password -->
            <div class="validate-input">
                <div class="wrap-input">
                    <label for="password" class="label-text">New password</label>
                    <x-text-input id="password" class="block mt-1 w-full input" type="password" 
                    name="password" placeholder="New password" required/>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 error-msg" />
            </div>

            <!-- Confirm Password -->
            <div class="validate-input">
                <div class="wrap-input">
                <label for="password" class="label-text">Confirm new password</label>
                    <x-text-input id="confirmPassword" class="block mt-1 w-full input" type="password" 
                    name="password_confirmation" placeholder="Confirm new password" required/>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 error-msg" />
            </div>

            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <x-primary-button class="submit-btn">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
