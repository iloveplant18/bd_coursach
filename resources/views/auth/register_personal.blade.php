<x-guest-layout>
    <h2 class="hidden">
        Register as a personal
    </h2>
    <form method="POST" action="{{ route('register_personal') }}">
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
            <x-datepicker
                name="date"
                id="default-datepicker"
                placeholder="Select birthday date"
                required
            />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>

        <!-- Post -->
        <div class="mt-4">
            <h3 class="m-0 text-xl">
                Choose your post
            </h3>

            <x-input-label class="mt-1" for="officiant" value="Officiant" />
            <x-radio name="post" id="officiant" value="officiant"/>

            <x-input-label class="mt-1" for="cleaner" value="Cleaner" />
            <x-radio name="post" id="cleaner" value="cleaner"/>

            <x-input-label class="mt-1" for="admin" value="Admin" />
            <x-radio name="post" id="admin" value="admin"/>

            <x-input-error :messages="$errors->get('post')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end gap-x-2 mt-4">
            <x-link href="{{ route('register') }}">
                Registrate as client
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