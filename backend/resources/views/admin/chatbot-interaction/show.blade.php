@extends('layouts.app')

@section('template_title')
    {{ $chatbotInteraction->name ?? __('Show') . " " . __('Chatbot Interaction') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Chatbot Interaction</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('chatbot-interactions.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $chatbotInteraction->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Session Id:</strong>
                                    {{ $chatbotInteraction->session_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Input Text:</strong>
                                    {{ $chatbotInteraction->input_text }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Input Metadata:</strong>
                                    {{ $chatbotInteraction->input_metadata }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Response Text:</strong>
                                    {{ $chatbotInteraction->response_text }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Response Metadata:</strong>
                                    {{ $chatbotInteraction->response_metadata }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Intent:</strong>
                                    {{ $chatbotInteraction->intent }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Sentiment:</strong>
                                    {{ $chatbotInteraction->sentiment }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Detected Risk:</strong>
                                    {{ $chatbotInteraction->detected_risk }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Detected Keywords:</strong>
                                    {{ $chatbotInteraction->detected_keywords }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
