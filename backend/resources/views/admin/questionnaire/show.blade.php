@extends('layouts.admin')

@section('template_title')
    {{ $questionnaire->title ?? __('Ver') . ' Cuestionario' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Cuestionario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.questionnaires.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Código:</strong>
                            {{ $questionnaire->code }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Título:</strong>
                            {{ $questionnaire->title }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Descripción:</strong>
                            {{ $questionnaire->description }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Versión:</strong>
                            {{ $questionnaire->version }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Creado Por:</strong>
                            {{ $questionnaire->created_by }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
