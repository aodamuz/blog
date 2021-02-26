@php
    $faker = app(\Faker\Generator::class);
@endphp
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- First Name -->
            <div>
                <x-label for="options-first_name" :value="__('First Name')" />

                <x-input id="options-first_name" class="block mt-1 w-full" type="text" name="options[first_name]" :value="old('options.first_name', $faker->firstName)" required autofocus />
            </div>

            <!-- Last Name -->
            <div class="mt-4">
                <x-label for="options-last_name" :value="__('Last Name')" />

                <x-input id="options-last_name" class="block mt-1 w-full" type="text" name="options[last_name]" :value="old('options.last_name', $faker->lastName)" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email" :value="old('email', $faker->unique()->safeEmail)" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    value="password"
                    required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    value="password"
                    required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
