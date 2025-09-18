@extends('layouts.admin')

@section('template_title')
    {{ $studentProfile->name ?? __('Ver') . " " . __('Perfil de Estudiante') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Perfil de Estudiante</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.student-profiles.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Id de Usuario:</strong>
                            {{ $studentProfile->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Código de Estudiante:</strong>
                            {{ $studentProfile->student_code }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha de Nacimiento:</strong>
                            {{ $studentProfile->birthdate }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Carrera:</strong>
                            {{ $studentProfile->career }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Semestre:</strong>
                            {{ $studentProfile->semester }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre del Grupo:</strong>
                            {{ $studentProfile->group_name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Consentimiento:</strong>
                            {{ $studentProfile->consent_given }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha de Consentimiento:</strong>
                            {{ $studentProfile->consent_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
