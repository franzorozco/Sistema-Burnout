@extends('layouts.admin')

@section('template_title')
    {{ __('Actualizar') }} Voto de Publicación
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Voto de Publicación</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.post-votes.update', $postVote->id) }}" role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('admin.post-vote.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
