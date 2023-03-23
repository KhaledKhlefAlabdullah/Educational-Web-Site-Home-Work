@extends('welcome')
@section('title','Admin Create User')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section class="container col-4 align-items-center" >
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Create User') }}
                            </h2>
                        </header>
                        <form method="post" action="{{ route('admin.store') }}" enctype="multipart/form-data" class="mt-6 col-5">
                            @csrf
                            <div>
                                <x-input-label for="email" :value="__('Email')" /><br>
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required  autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            </div>
                            <div>
                                <x-input-label for="email" :value="__('User type')" /><br>
                                <select class="form-control" name="user_type" id="user_type" >
                                    <option value="student">{{ __('Student') }}</option>
                                    <option value="admin">{{ __('Admin') }}</option>
                                    <option value="teacher">{{ __('Teacher') }}</option>
                                </select>

                                <x-input-error class="mt-2" :messages="$errors->get('user_type')" />
                            </div>
                            <div>
                                <x-input-label for="password" :value="__('Password')" /><br>
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" /><br>
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div><br>

                            <div class="flex items-center gap-4">
                                <x-primary-button class="btn btn-success">{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
