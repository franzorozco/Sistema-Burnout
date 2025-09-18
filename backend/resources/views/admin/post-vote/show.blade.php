@extends('layouts.admin')

@section('template_title')
    {{ __('Mostrar') }} Voto de Publicación
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Voto de Publicación</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.post-votes.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Usuario Id:</strong>
                            {{ $postVote->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Publicación Id:</strong>
                            {{ $postVote->post_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Comentario Id:</strong>
                            {{ $postVote->comment_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Voto:</strong>
                            {{ $postVote->vote }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
