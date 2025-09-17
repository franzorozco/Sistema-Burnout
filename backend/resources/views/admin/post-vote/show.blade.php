@extends('layouts.app')

@section('template_title')
    {{ $postVote->name ?? __('Show') . " " . __('Post Vote') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Post Vote</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('post-votes.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $postVote->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Post Id:</strong>
                                    {{ $postVote->post_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Comment Id:</strong>
                                    {{ $postVote->comment_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Vote:</strong>
                                    {{ $postVote->vote }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
