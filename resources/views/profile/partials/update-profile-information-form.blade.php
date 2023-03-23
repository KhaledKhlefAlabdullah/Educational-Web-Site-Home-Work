<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('First Name')" /><br>
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user_details->first_name)" required autofocus autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

         <div>
            <x-input-label for="name" :value="__('Last Name')" /><br>
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user_details->last_name)" required autofocus autocomplete="last_name" />
            <x-input-error class="mt-2 " :messages="$errors->get('last_name')" />
         </div>
        <div>
            <x-input-label for="image" :value="__('Image Profile')" /><br>
            <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" required autofocus accept="image/*" />
            <x-input-error class="mt-2 text-danger" :messages="$errors->get('image')" />
        </div>
         <div>
            <x-input-label for="name" :value="__('Birth Date')" /><br>
            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $user_details->birth_date)" required autofocus autocomplete="birth_date" />
            <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
         </div>

        <div>
            <x-input-label for="name" :value="__('Phone Number')" /><br>
            <x-text-input id="phone_number" name="phone_number" type="number" class="mt-1 block w-full" :value="old('phone_number', $user_details->phone_number)" required autofocus autocomplete="phone_number" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Whatsapp Link')" /><br>
            <x-text-input id="whatsapp_link" name="whatsapp_link" type="url" class="mt-1 block w-full" :value="old('whatsapp_link', $user_details->whatsapp_link)" required autofocus autocomplete="whatsapp_link" />
            <x-input-error class="mt-2" :messages="$errors->get('whatsapp_link')" />
        </div>
        <div>
            <x-input-label for="name" :value="__('Github Link')" /><br>
            <x-text-input id="github_link" name="github_link" type="url" class="mt-1 block w-full" :value="old('github_link', $user_details->github_link)" required autofocus autocomplete="github_link" />
            <x-input-error class="mt-2" :messages="$errors->get('github_link')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Facebook Link')" /><br>
            <x-text-input id="facebook_link" name="facebook_link" type="url" class="mt-1 block w-full" :value="old('facebook_link', $user_details->facebook_link)" required autofocus autocomplete="facebook_link" />
            <x-input-error class="mt-2" :messages="$errors->get('facebook_link')" />
        </div>


        <div>
            <x-input-label for="name" :value="__('Instagram Link')" /><br>
            <x-text-input id="instagram_link" name="instagram_link" type="url" class="mt-1 block w-full" :value="old('instagram_link', $user_details->instagram_link)" required autofocus autocomplete="instagram_link" />
            <x-input-error class="mt-2" :messages="$errors->get('instagram_link')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" /><br>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <br>
        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-success">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
