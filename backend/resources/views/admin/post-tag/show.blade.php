@extends('layouts.admin')

@section('template_title')
    {{ __('Mostrar Etiqueta de Publicación') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} {{ __('Etiqueta de Publicación') }}</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.post-tags.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>{{ __('Post Id') }}:</strong>
                            {{ $postTag->post_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>{{ __('Etiqueta') }}:</strong>
                            {{ $postTag->tag }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
