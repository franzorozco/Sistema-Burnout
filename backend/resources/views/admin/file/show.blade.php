@extends('layouts.app')

@section('template_title')
    {{ $file->name ?? __('Mostrar') . " " . __('Archivo') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="card-title">{{ __('Mostrar') }} Archivo</span>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.files.index') }}"> {{ __('Volver') }}</a>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Usuario dueño:</strong>
                            {{ $file->owner_user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo relacionado:</strong>
                            {{ $file->related_type }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>ID relacionado:</strong>
                            {{ $file->related_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre de archivo:</strong>
                            {{ $file->filename }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>URL:</strong>
                            {{ $file->url }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo MIME:</strong>
                            {{ $file->mime_type }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tamaño (bytes):</strong>
                            {{ $file->size_bytes }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Checksum:</strong>
                            {{ $file->checksum }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
