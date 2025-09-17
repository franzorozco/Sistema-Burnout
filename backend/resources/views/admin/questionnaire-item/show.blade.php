@extends('layouts.app')

@section('template_title')
    {{ $questionnaireItem->name ?? __('Show') . " " . __('Questionnaire Item') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Questionnaire Item</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('questionnaire-items.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Questionnaire Id:</strong>
                                    {{ $questionnaireItem->questionnaire_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Item Order:</strong>
                                    {{ $questionnaireItem->item_order }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Question Text:</strong>
                                    {{ $questionnaireItem->question_text }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Response Type:</strong>
                                    {{ $questionnaireItem->response_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Meta:</strong>
                                    {{ $questionnaireItem->meta }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
