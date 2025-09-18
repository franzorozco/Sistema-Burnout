@extends('layouts.admin')

@section('template_title')
    {{ $questionnaireItem->name ?? __('Ver') . " Ítem de Cuestionario" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Ítem de Cuestionario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.questionnaire-items.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Cuestionario:</strong>
                            {{ $questionnaireItem->questionnaire_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Orden del Ítem:</strong>
                            {{ $questionnaireItem->item_order }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Pregunta:</strong>
                            {{ $questionnaireItem->question_text }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo de Respuesta:</strong>
                            {{ $questionnaireItem->response_type }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Meta:</strong>
                            {{ $questionnaireItem->meta }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
