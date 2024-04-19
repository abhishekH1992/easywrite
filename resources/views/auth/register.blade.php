<x-guest-layout>
    <div class="logo-block text-center">
        <img src="/assets/images/EasyWrite.svg">
    </div>
    <div class="auth-forms register-form">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Name -->
            <div class="row">
                <div class="validate-input col-md-6">
                    <div class="wrap-input md:mr-1">
                        <label for="firstName" class="label-text">First name</label>
                        <x-text-input id="fname" class="block mt-1 w-full input" type="text" 
                        name="fname" :value="old('fname')" placeholder="Your first Name" autofocus=true required/>
                        <!-- <span class="label" data-placeholder="First Name"></span> -->
                    </div>
                    <x-input-error :messages="$errors->get('fname')" class="mt-2 error-msg" />
                </div>
                <div class="validate-input col-md-6">
                    <div class="wrap-input md:ml-1">
                        <label for="lastName" class="label-text">Last name</label>
                        <x-text-input id="lname" class="block mt-1 w-full input" type="text" 
                        name="lname" :value="old('lname')" placeholder="Your last Name" required/>
                        <!-- <span class="label" data-placeholder="Last Name"></span> -->
                    </div>
                    <x-input-error :messages="$errors->get('lname')" class="mt-2 error-msg" />
                </div>
            </div>

            <!-- Email Address -->
            <div class="validate-input">
                <div class="wrap-input">
                    <label for="Email" class="label-text">Email</label>                    
                    <x-text-input id="email" class="block mt-1 w-full input" type="email" name="email" 
                    :value="old('email')" placeholder="Your email address" required/>
                    <!-- <span class="label" data-placeholder="Email"></span> -->
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 error-msg" />
            </div>

            <!-- Password -->
            <div class="validate-input">
                <div class="wrap-input">
                    <label for="password" class="label-text">Password</label>
                    <x-text-input id="password" class="block mt-1 w-full input" type="password" name="password" 
                    required autocomplete="current-password" placeholder="Your password"/>
                    <!-- <span class="label" data-placeholder="Password"></span> -->
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 error-msg" />
            </div>

            <!-- Confirm Password -->
            <div class="validate-input">
                <div class="wrap-input">
                    <label for="confirm password" class="label-text">Confirm password</label>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full input" type="password" 
                    name="password_confirmation" placeholder="Your confirm password" required/>
                    <!-- <span class="label" data-placeholder="Confirm Password"></span> -->
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 error-msg" />
            </div>

            <div class="forget-password-link">
                <a class="underline hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>

            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <x-primary-button class="submit-btn">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
