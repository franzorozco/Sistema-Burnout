@extends('layouts.admin')

@section('template_title')
    {{ $comment->name ?? __('Ver') . " " . __('Comentario') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Comentario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.comments.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Id del Post:</strong>
                            {{ $comment->post_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Id del Usuario:</strong>
                            {{ $comment->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Id del Comentario Padre:</strong>
                            {{ $comment->parent_comment_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Contenido:</strong>
                            {{ $comment->body }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Puntuación:</strong>
                            {{ $comment->score }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
