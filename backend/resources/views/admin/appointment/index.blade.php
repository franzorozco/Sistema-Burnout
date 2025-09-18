@extends('layouts.admin')

@section('template_title')
    Citas
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Citas') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nueva') }}
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
                                        <th>Id del Perfil del Estudiante</th>
                                        <th>Id del Profesional</th>
                                        <th>Programado Para</th>
                                        <th>Duración (minutos)</th>
                                        <th>Estado</th>
                                        <th>Notas</th>
                                        <th>Creado Por</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $appointment->student_profile_id }}</td>
                                            <td>{{ $appointment->professional_id }}</td>
                                            <td>{{ $appointment->scheduled_at }}</td>
                                            <td>{{ $appointment->duration_minutes }}</td>
                                            <td>{{ $appointment->status }}</td>
                                            <td>{{ $appointment->notes }}</td>
                                            <td>{{ $appointment->created_by }}</td>
                                            <td>
                                                <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.appointments.show', $appointment->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.appointments.edit', $appointment->id) }}">
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
                {!! $appointments->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
