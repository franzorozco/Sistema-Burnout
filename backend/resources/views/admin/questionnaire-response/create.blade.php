@extends('layouts.admin')

@section('template_title')
    {{ __('Crear') }} Respuesta de Cuestionario
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear') }} Respuesta de Cuestionario</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.questionnaire-responses.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('admin.questionnaire-response.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
