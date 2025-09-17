@extends('layouts.app')

@section('template_title')
    {{ $studentRotation->name ?? __('Show') . " " . __('Student Rotation') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Student Rotation</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('student-rotations.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Student Profile Id:</strong>
                                    {{ $studentRotation->student_profile_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Rotation Id:</strong>
                                    {{ $studentRotation->rotation_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Assigned At:</strong>
                                    {{ $studentRotation->assigned_at }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Shift Type:</strong>
                                    {{ $studentRotation->shift_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Notes:</strong>
                                    {{ $studentRotation->notes }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
