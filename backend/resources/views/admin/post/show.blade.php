@extends('layouts.app')

@section('template_title')
    {{ $post->name ?? __('Show') . " " . __('Post') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Post</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('posts.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $post->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Title:</strong>
                                    {{ $post->title }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Body:</strong>
                                    {{ $post->body }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Anonymous:</strong>
                                    {{ $post->is_anonymous }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Score:</strong>
                                    {{ $post->score }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Views:</strong>
                                    {{ $post->views }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
