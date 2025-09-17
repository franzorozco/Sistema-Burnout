@extends('layouts.app')

@section('template_title')
    {{ $postTag->name ?? __('Show') . " " . __('Post Tag') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Post Tag</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('post-tags.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Post Id:</strong>
                                    {{ $postTag->post_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tag:</strong>
                                    {{ $postTag->tag }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
