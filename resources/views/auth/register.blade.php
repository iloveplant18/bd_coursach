<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Datepicker -->
        <div class="mt-4">
            <x-input-label for="date" value="Choose your birthday date" />
            <x-datepicker
                class="mt-1 block"
                name="date"
                id="default-datepicker"
                placeholder="Select birthday date"
                required
            />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="tel" value="Phone number" />
            <x-text-input
                id="tel"
                class="block mt-1 w-full"
                type="tel"
                name="tel"
                required
            />
            <x-input-error :messages="$errors->get('tel')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="address" value="Address" />
            <x-text-input
                id="address"
                class="block mt-1 w-full"
                type="text"
                name="address"
                required
            />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="passport" value="Passport" />
            <x-text-input
                id="passport"
                class="block mt-1 w-full"
                type="text"
                name="passport"
                required
            />
            <x-input-error :messages="$errors->get('passport')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end gap-x-2 mt-4">
            <x-link href="{{ route('register_personal') }}">
                Registrate as personal
            </x-link>
            <x-link href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </x-link>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
