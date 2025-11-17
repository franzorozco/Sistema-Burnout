<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Registro</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background-color: #3a3a7a;
                background-image: linear-gradient(135deg, #50a695ff 0%, #a1b7a5ff 50%, #719b78ff 100%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            <div class="w-full sm:max-w-lg mt-6 mb-6 px-8 py-10 bg-white shadow-2xl overflow-hidden rounded-2xl">

                <div class="flex justify-center mb-8">
                    <a href="/">
                        <img src="{{ asset('img/logo-unifranz.png') }}" alt="Burnout Logo" class="w-48" />
                    </a>
                </div>

                <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">
                    Crear una cuenta
                </h2>

                <x-auth-session-status class="mb-6 p-4 rounded-md bg-green-50 text-green-700 font-medium" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-base font-semibold text-gray-700" />
                        <x-text-input id="name" class="block mt-2 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="email" :value="__('Email')" class="text-base font-semibold text-gray-700" />
                        <x-text-input id="email" class="block mt-2 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="password" :value="__('Password')" class="text-base font-semibold text-gray-700" />
                        <x-text-input id="password" class="block mt-2 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-base font-semibold text-gray-700" />
                        <x-text-input id="password_confirmation" class="block mt-2 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-10">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-lg text-base font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-700 hover:from-purple-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                            {{ __('Register') }}
                        </button>
                    </div>

                    <p class="text-center text-sm text-gray-600 mt-8">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-800 underline transition duration-150 ease-in-out">
                            Inicia sesión aquí
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>
