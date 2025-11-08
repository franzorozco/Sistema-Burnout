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
                 
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">

                                        <span id="card_title">
                                            {{ __('Usuarios') }}
                                        </span>

                                        <div class="float-right">
                                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                                {{ __('Crear Nuevo') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success m-4">
                                        <p>{{ $message }}</p>
                                    </div>
                                @endif

                                <div class="card-body bg-white">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Email</th>
                                                    <th>Nombre</th>
                                                    <th>Apellido Paterno</th>
                                                    <th>Apellido Materno</th>
                                                    <th>Teléfono</th>
                                                    <th>Dirección</th>
                                                    <th>Activo</th>
                                                    <th>Último Inicio de Sesión</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->paternal_surname }}</td>
                                                        <td>{{ $user->maternal_surname }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>{{ $user->address }}</td>
                                                        <td>{{ $user->is_active ? 'Sí' : 'No' }}</td>
                                                        <td>{{ $user->last_login_at }}</td>
                                                        <td>
                                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                                                    <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                                </a>
                                                                <a class="btn btn-sm btn-success" href="{{ route('admin.users.edit', $user->id) }}">
                                                                    <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                                </a>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;">
                                                                    <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {!! $users->withQueryString()->links() !!}
                        </div>
                    </div>
                </div>
     
            </div>
        </div>
        <!-- Bootstrap JS y dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/2b2c42c507.js" crossorigin="anonymous"></script>
    </body>
</html>
