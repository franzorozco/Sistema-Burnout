@extends('layouts.app')

@section('template_title')
    {{ $appointment->name ?? __('Show') . " " . __('Appointment') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Appointment</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('appointments.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Student Profile Id:</strong>
                                    {{ $appointment->student_profile_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Professional Id:</strong>
                                    {{ $appointment->professional_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Scheduled At:</strong>
                                    {{ $appointment->scheduled_at }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Duration Minutes:</strong>
                                    {{ $appointment->duration_minutes }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Status:</strong>
                                    {{ $appointment->status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Notes:</strong>
                                    {{ $appointment->notes }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Created By:</strong>
                                    {{ $appointment->created_by }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
