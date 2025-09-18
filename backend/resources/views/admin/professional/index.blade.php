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
