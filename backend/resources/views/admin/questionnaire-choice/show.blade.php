@extends('layouts.app')

@section('template_title')
    {{ $questionnaireChoice->name ?? __('Show') . " " . __('Questionnaire Choice') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Questionnaire Choice</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('questionnaire-choices.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Item Id:</strong>
                                    {{ $questionnaireChoice->item_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Choice Order:</strong>
                                    {{ $questionnaireChoice->choice_order }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Value:</strong>
                                    {{ $questionnaireChoice->value }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Label:</strong>
                                    {{ $questionnaireChoice->label }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
