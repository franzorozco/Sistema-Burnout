@extends('layouts.app')

@section('template_title')
    {{ $questionnaire->name ?? __('Show') . " " . __('Questionnaire') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Questionnaire</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('questionnaires.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Code:</strong>
                                    {{ $questionnaire->code }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Title:</strong>
                                    {{ $questionnaire->title }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Description:</strong>
                                    {{ $questionnaire->description }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Version:</strong>
                                    {{ $questionnaire->version }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Created By:</strong>
                                    {{ $questionnaire->created_by }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
