<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @include('layouts.partials.admin.navigation')
        @include('layouts.partials.admin.sidebar')

        <div class="p-4 sm:ml-64 space-y-4">
            <div class="p-4  rounded-lg dark:border-gray-700 mt-14">
                 
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">

                                        <span id="card_title">
                                            {{ __('Users') }}
                                        </span>

                                        <div class="float-right">
                                            <a href="{{ route('admin.users.export', request()->query()) }}" class="btn btn-secondary btn-sm me-2" data-placement="left">
                                                <i class="fa fa-file-pdf"></i> {{ __('Descargar PDF') }}
                                            </a>
                                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                            {{ __('Create New') }}
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
                                    <form method="GET" class="mb-3">
                                        <div class="row g-2 align-items-end">
                                            <div class="col-md-3">
                                                <label class="form-label">Email</label>
                                                <input type="text" name="email" value="{{ request('email') }}" class="form-control" placeholder="Email">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Nombre">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Activo</label>
                                                <select name="is_active" class="form-select">
                                                    <option value="">Todos</option>
                                                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Sí</option>
                                                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex gap-2">
                                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Limpiar</a>
                                                <a href="{{ route('admin.users.export', request()->query()) }}" class="btn btn-outline-danger ms-auto">Descargar PDF</a>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead">
                                                <tr>
                                                    <th>No</th>
                                                    
                                                <th >Email</th>
                                                <th >Name</th>
                                                <th >Paternal Surname</th>
                                                <th >Maternal Surname</th>
                                                <th >Phone</th>
                                                <th >Address</th>
                                                <th >Is Active</th>
                                                <th >Last Login At</th>

                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        
                                                    <td >{{ $user->email }}</td>
                                                    <td >{{ $user->name }}</td>
                                                    <td >{{ $user->paternal_surname }}</td>
                                                    <td >{{ $user->maternal_surname }}</td>
                                                    <td >{{ $user->phone }}</td>
                                                    <td >{{ $user->address }}</td>
                                                    <td >{{ $user->is_active }}</td>
                                                    <td >{{ $user->last_login_at }}</td>

                                                        <td>
                                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                                <a class="btn btn-sm btn-primary " href="{{ route('admin.users.show', $user->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                                <a class="btn btn-sm btn-success" href="{{ route('admin.users.edit', $user->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/2b2c42c507.js" crossorigin="anonymous"></script>
    </body>
</html>