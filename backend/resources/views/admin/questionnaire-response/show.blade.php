@extends('layouts.admin')

@section('template_title')
    {{ $questionnaireResponse->name ?? 'Mostrar Respuesta de Cuestionario' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">Mostrar Respuesta de Cuestionario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.questionnaire-responses.index') }}"> Volver</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Cuestionario:</strong>
                            {{ $questionnaireResponse->questionnaire_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Perfil del Estudiante:</strong>
                            {{ $questionnaireResponse->student_profile_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Usuario:</strong>
                            {{ $questionnaireResponse->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Enviado en:</strong>
                            {{ $questionnaireResponse->submitted_at }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Puntuación Resumen:</strong>
                            {{ $questionnaireResponse->summary_score }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Datos Crudos:</strong>
                            {{ $questionnaireResponse->raw }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
