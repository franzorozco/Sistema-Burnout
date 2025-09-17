@extends('layouts.app')

@section('template_title')
    {{ $notification->name ?? __('Show') . " " . __('Notification') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Notification</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('notifications.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $notification->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Type:</strong>
                                    {{ $notification->type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Payload:</strong>
                                    {{ $notification->payload }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Read:</strong>
                                    {{ $notification->is_read }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
