<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @include('layouts.partials.admin.navigation')
        @include('layouts.partials.admin.sidebar')

        <div class="p-4 sm:ml-64 space-y-4">
            <div class="p-4 rounded-lg dark:border-gray-700 mt-14">
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Usuario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.users.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Email:</strong>
                                    {{ $user->email }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $user->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Apellido Paterno:</strong>
                                    {{ $user->paternal_surname }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Apellido Materno:</strong>
                                    {{ $user->maternal_surname }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Teléfono:</strong>
                                    {{ $user->phone }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Dirección:</strong>
                                    {{ $user->address }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Activo:</strong>
                                    {{ $user->is_active ? 'Sí' : 'No' }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Último Inicio de Sesión:</strong>
                                    {{ $user->last_login_at }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

            </div>
        </div>
        <!-- Bootstrap JS y dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/2b2c42c507.js" crossorigin="anonymous"></script>
    </body>
</html>
