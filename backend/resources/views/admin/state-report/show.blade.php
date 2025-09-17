@extends('layouts.app')

@section('template_title')
    {{ $stateReport->name ?? __('Show') . " " . __('State Report') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} State Report</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('state-reports.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Student Profile Id:</strong>
                                    {{ $stateReport->student_profile_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Report Date:</strong>
                                    {{ $stateReport->report_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Mood:</strong>
                                    {{ $stateReport->mood }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Energy Level:</strong>
                                    {{ $stateReport->energy_level }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Sleep Hours:</strong>
                                    {{ $stateReport->sleep_hours }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Stress Score:</strong>
                                    {{ $stateReport->stress_score }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Symptoms:</strong>
                                    {{ $stateReport->symptoms }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Location:</strong>
                                    {{ $stateReport->location }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
