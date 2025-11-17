@extends('layouts.admin')

@section('template_title')
    Profesionales
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Profesionales') }}
                            </span>

                                                        <div class="float-right">
                                                                <a href="{{ route('admin.professionals.export', request()->query()) }}" class="btn btn-secondary btn-sm me-2" data-placement="left">
                                                                        <i class="fa fa-file-pdf"></i> {{ __('Descargar PDF') }}
                                                                </a>
                                                                <a href="{{ route('admin.professionals.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                <div class="col-md-2">
                                    <label class="form-label">Usuario</label>
                                    <input type="text" name="user_id" value="{{ request('user_id') }}" class="form-control" placeholder="User ID">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Profesión</label>
                                    <input type="text" name="profession" value="{{ request('profession') }}" class="form-control" placeholder="Profesión">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Número de licencia</label>
                                    <input type="text" name="license_number" value="{{ request('license_number') }}" class="form-control" placeholder="Licencia">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Disponible</label>
                                    <select name="is_available" class="form-select">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('is_available') === '1' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ request('is_available') === '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                    <a href="{{ route('admin.professionals.index') }}" class="btn btn-secondary">Limpiar</a>
                                    <a href="{{ route('admin.professionals.export', request()->query()) }}" class="btn btn-outline-danger ms-auto">Descargar PDF</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Id de Usuario</th>
                                        <th>Profesión</th>
                                        <th>Número de Licencia</th>
                                        <th>Biografía</th>
                                        <th>Disponible</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($professionals as $professional)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $professional->user_id }}</td>
                                            <td>{{ $professional->profession }}</td>
                                            <td>{{ $professional->license_number }}</td>
                                            <td>{{ $professional->bio }}</td>
                                            <td>{{ $professional->is_available ? 'Sí' : 'No' }}</td>
                                            <td>
                                                <form action="{{ route('admin.professionals.destroy', $professional->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.professionals.show', $professional->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.professionals.edit', $professional->id) }}">
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
                {!! $professionals->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
