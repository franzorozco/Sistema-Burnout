@extends('layouts.admin')

@section('template_title')
    {{ $stateReport->name ?? 'Mostrar Reporte de Estado' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">Mostrar Reporte de Estado</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.state-reports.index') }}"> Volver</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Perfil de Estudiante:</strong>
                            {{ $stateReport->student_profile_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha del Reporte:</strong>
                            {{ $stateReport->report_date }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Estado de Ánimo:</strong>
                            {{ $stateReport->mood }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nivel de Energía:</strong>
                            {{ $stateReport->energy_level }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Horas de Sueño:</strong>
                            {{ $stateReport->sleep_hours }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Puntaje de Estrés:</strong>
                            {{ $stateReport->stress_score }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Síntomas:</strong>
                            {{ $stateReport->symptoms }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Ubicación:</strong>
                            {{ $stateReport->location }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
