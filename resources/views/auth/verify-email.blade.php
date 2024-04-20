<x-guest-layout>
    <div class="logo-block text-center">
        <img src="/assets/images/EasyWrite.svg" width="300px" height="100px">
    </div>
    <div class="auth-forms">
        <form method="POST" action="{{ route('verification.send') }}">

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            @csrf
            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <x-primary-button class="submit-btn">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="flex items-center justify-end mt-4 submit-btn-block">
                <x-primary-button class="submit-btn">
                    {{ __('Log Out') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
