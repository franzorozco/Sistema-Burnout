@extends('layouts.app')

@section('template_title')
    {{ $questionnaireResponse->name ?? __('Show') . " " . __('Questionnaire Response') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Questionnaire Response</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('questionnaire-responses.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Questionnaire Id:</strong>
                                    {{ $questionnaireResponse->questionnaire_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Student Profile Id:</strong>
                                    {{ $questionnaireResponse->student_profile_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $questionnaireResponse->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Submitted At:</strong>
                                    {{ $questionnaireResponse->submitted_at }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Summary Score:</strong>
                                    {{ $questionnaireResponse->summary_score }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Raw:</strong>
                                    {{ $questionnaireResponse->raw }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
