@extends('layouts.app')

@section('template_title')
    {{ $studentProfile->name ?? __('Show') . " " . __('Student Profile') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Student Profile</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('student-profiles.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $studentProfile->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Student Code:</strong>
                                    {{ $studentProfile->student_code }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Birthdate:</strong>
                                    {{ $studentProfile->birthdate }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Career:</strong>
                                    {{ $studentProfile->career }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Semester:</strong>
                                    {{ $studentProfile->semester }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Group Name:</strong>
                                    {{ $studentProfile->group_name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Consent Given:</strong>
                                    {{ $studentProfile->consent_given }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Consent At:</strong>
                                    {{ $studentProfile->consent_at }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
