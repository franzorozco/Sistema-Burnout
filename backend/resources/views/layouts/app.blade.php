<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        {{-- Usamos la misma fuente que tu login.blade.php para consistencia --}}
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                /* Colores extraídos de tu logo */
                background-color: #3a3a7a;
                background-image: linear-gradient(135deg, #50a695ff 0%, #a1b7a5ff 50%, #719b78ff 100%);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        {{-- Eliminamos 'bg-gray-100' para que se vea el degradado del body --}}
        <div class="min-h-screen">
            @include('layouts.navigation')

            @if (isset($header))
                {{-- El header (ej. "Dashboard") se mantiene blanco para legibilidad --}}
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
