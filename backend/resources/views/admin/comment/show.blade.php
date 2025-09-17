@extends('layouts.app')

@section('template_title')
    {{ $comment->name ?? __('Show') . " " . __('Comment') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Comment</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('comments.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Post Id:</strong>
                                    {{ $comment->post_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $comment->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Parent Comment Id:</strong>
                                    {{ $comment->parent_comment_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Body:</strong>
                                    {{ $comment->body }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Score:</strong>
                                    {{ $comment->score }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
