@extends('layouts.app')

@section('template_title')
    {{ $professional->name ?? __('Show') . " " . __('Professional') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Professional</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('professionals.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $professional->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Profession:</strong>
                                    {{ $professional->profession }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>License Number:</strong>
                                    {{ $professional->license_number }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Bio:</strong>
                                    {{ $professional->bio }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Available:</strong>
                                    {{ $professional->is_available }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
