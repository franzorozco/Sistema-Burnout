@extends('layouts.admin')

@section('template_title')
    {{ $appointment->name ?? __('Ver') . " " . __('Cita') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Cita</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.appointments.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Id del Perfil del Estudiante:</strong>
                            {{ $appointment->student_profile_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Id del Profesional:</strong>
                            {{ $appointment->professional_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Programado Para:</strong>
                            {{ $appointment->scheduled_at }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Duración (minutos):</strong>
                            {{ $appointment->duration_minutes }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Estado:</strong>
                            {{ $appointment->status }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Notas:</strong>
                            {{ $appointment->notes }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Creado Por:</strong>
                            {{ $appointment->created_by }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
