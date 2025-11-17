@extends('layouts.admin')

@section('template_title')
    Roles
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Roles') }}
                            </span>

                                                         <div class="float-right">
                                                                <a href="{{ route('admin.roles.export', request()->query()) }}" class="btn btn-secondary btn-sm me-2" data-placement="left">
                                                                    <i class="fa fa-file-pdf"></i> {{ __('Descargar PDF') }}
                                                                </a>
                                                                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                <div class="col-md-3">
                                    <label class="form-label">Guardia</label>
                                    <input type="text" name="guard_name" value="{{ request('guard_name') }}" class="form-control" placeholder="Guard">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Creado por</label>
                                    <input type="text" name="created_by" value="{{ request('created_by') }}" class="form-control" placeholder="Usuario">
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Limpiar</a>
                                    <a href="{{ route('admin.roles.export', request()->query()) }}" class="btn btn-outline-danger ms-auto">Descargar PDF</a>
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
                                        <th>Descripción</th>
                                        <th>Creado Por</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->guard_name }}</td>
                                            <td>{{ $role->description }}</td>
                                            <td>{{ $role->created_by }}</td>
                                            <td>
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.roles.show', $role->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.roles.edit', $role->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar este rol?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $roles->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
