@extends('layouts.admin')

@section('template_title')
    {{ $post->name ?? __('Ver') . " " . __('Publicación') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Publicación</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.posts.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Id del Usuario:</strong>
                            {{ $post->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Título:</strong>
                            {{ $post->title }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Contenido:</strong>
                            {{ $post->body }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Es Anónimo:</strong>
                            {{ $post->is_anonymous }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Puntuación:</strong>
                            {{ $post->score }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Vistas:</strong>
                            {{ $post->views }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
