@extends('layouts.app')

@section('template_title')
    {{ $chatbotAlert->name ?? __('Show') . " " . __('Chatbot Alert') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Chatbot Alert</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('chatbot-alerts.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Chatbot Interaction Id:</strong>
                                    {{ $chatbotAlert->chatbot_interaction_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Student Profile Id:</strong>
                                    {{ $chatbotAlert->student_profile_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Alert Type:</strong>
                                    {{ $chatbotAlert->alert_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Severity:</strong>
                                    {{ $chatbotAlert->severity }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Resolved At:</strong>
                                    {{ $chatbotAlert->resolved_at }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Resolved By:</strong>
                                    {{ $chatbotAlert->resolved_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Notes:</strong>
                                    {{ $chatbotAlert->notes }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
