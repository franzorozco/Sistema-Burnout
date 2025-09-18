@extends('layouts.admin')

@section('template_title')
    Reportes de Estado
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Reportes de Estado
                            </span>

                            <div class="float-right">
                                <a href="{{ route('admin.state-reports.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  Crear Nuevo
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
                                        <th>Perfil de Estudiante</th>
                                        <th>Fecha del Reporte</th>
                                        <th>Estado de Ánimo</th>
                                        <th>Nivel de Energía</th>
                                        <th>Horas de Sueño</th>
                                        <th>Puntaje de Estrés</th>
                                        <th>Síntomas</th>
                                        <th>Ubicación</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stateReports as $stateReport)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $stateReport->student_profile_id }}</td>
                                            <td>{{ $stateReport->report_date }}</td>
                                            <td>{{ $stateReport->mood }}</td>
                                            <td>{{ $stateReport->energy_level }}</td>
                                            <td>{{ $stateReport->sleep_hours }}</td>
                                            <td>{{ $stateReport->stress_score }}</td>
                                            <td>{{ $stateReport->symptoms }}</td>
                                            <td>{{ $stateReport->location }}</td>

                                            <td>
                                                <form action="{{ route('admin.state-reports.destroy', $stateReport->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.state-reports.show', $stateReport->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> Ver
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.state-reports.edit', $stateReport->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> Editar
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar este registro?') ? this.closest('form').submit() : false;">
                                                        <i class="fa fa-fw fa-trash"></i> Eliminar
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
                {!! $stateReports->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
