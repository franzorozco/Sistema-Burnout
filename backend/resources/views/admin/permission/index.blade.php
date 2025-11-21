@extends('layouts.admin')

@section('template_title')
    Permisos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Permisos') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('admin.permissions.export', request()->query()) }}" class="btn btn-secondary btn-sm me-2" data-placement="left">
                                    <i class="fa fa-file-pdf"></i> {{ __('Descargar PDF') }}
                                </a>
                                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
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
                        <form method="GET" class="mb-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Nombre">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Guardia</label>
                                    <input type="text" name="guard_name" value="{{ request('guard_name') }}" class="form-control" placeholder="Guard">
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Limpiar</a>
                                    <a href="{{ route('admin.permissions.export', request()->query()) }}" class="btn btn-outline-danger ms-auto">Descargar PDF</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Guardia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                            <td>
                                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.permissions.show', $permission->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.permissions.edit', $permission->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar este permiso?') ? this.closest('form').submit() : false;">
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
                {!! $permissions->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
