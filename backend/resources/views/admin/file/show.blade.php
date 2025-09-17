@extends('layouts.app')

@section('template_title')
    {{ $file->name ?? __('Show') . " " . __('File') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} File</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('files.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Owner User Id:</strong>
                                    {{ $file->owner_user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Related Type:</strong>
                                    {{ $file->related_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Related Id:</strong>
                                    {{ $file->related_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Filename:</strong>
                                    {{ $file->filename }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Url:</strong>
                                    {{ $file->url }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Mime Type:</strong>
                                    {{ $file->mime_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Size Bytes:</strong>
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
