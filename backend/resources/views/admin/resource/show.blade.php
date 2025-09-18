@extends('layouts.admin')

@section('template_title')
    {{ $resource->name ?? __('Ver') . " " . __('Recurso') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Recurso</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.resources.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Título:</strong>
                            {{ $resource->title }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo:</strong>
                            {{ $resource->type }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Resumen:</strong>
                            {{ $resource->summary }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Contenido:</strong>
                            {{ $resource->content }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>URL:</strong>
                            {{ $resource->url }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Id del Autor:</strong>
                            {{ $resource->author_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Validado Por:</strong>
                            {{ $resource->validated_by }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha de Validación:</strong>
                            {{ $resource->validated_at }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Etiquetas:</strong>
                            {{ $resource->tags }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
