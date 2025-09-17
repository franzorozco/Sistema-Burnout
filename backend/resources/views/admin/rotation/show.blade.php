@extends('layouts.app')

@section('template_title')
    {{ $rotation->name ?? __('Show') . " " . __('Rotation') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Rotation</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('rotations.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $rotation->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Location:</strong>
                                    {{ $rotation->location }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Start Date:</strong>
                                    {{ $rotation->start_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>End Date:</strong>
                                    {{ $rotation->end_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Rural:</strong>
                                    {{ $rotation->is_rural }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Details:</strong>
                                    {{ $rotation->details }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
