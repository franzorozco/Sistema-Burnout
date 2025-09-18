@extends('layouts.admin')

@section('template_title')
    {{ $questionnaireChoice->name ?? __('Mostrar') . " " . __('Opción de Cuestionario') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Opción de Cuestionario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.questionnaire-choices.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Id del Ítem:</strong>
                            {{ $questionnaireChoice->item_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Orden de la Opción:</strong>
                            {{ $questionnaireChoice->choice_order }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Valor:</strong>
                            {{ $questionnaireChoice->value }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Etiqueta:</strong>
                            {{ $questionnaireChoice->label }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
