@extends('layouts.app')

@section('template_title')
    {{ $resource->name ?? __('Show') . " " . __('Resource') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Resource</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('resources.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Title:</strong>
                                    {{ $resource->title }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Type:</strong>
                                    {{ $resource->type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Summary:</strong>
                                    {{ $resource->summary }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Content:</strong>
                                    {{ $resource->content }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Url:</strong>
                                    {{ $resource->url }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Author Id:</strong>
                                    {{ $resource->author_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Validated By:</strong>
                                    {{ $resource->validated_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Validated At:</strong>
                                    {{ $resource->validated_at }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tags:</strong>
                                    {{ $resource->tags }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
