@extends('layouts.admin')

@section('template_title')
    {{ $chatbotInteraction->name ?? 'Mostrar Interacción del Chatbot' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">Mostrar Interacción del Chatbot</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.chatbot-interactions.index') }}"> Volver</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>ID Usuario:</strong>
                            {{ $chatbotInteraction->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>ID Sesión:</strong>
                            {{ $chatbotInteraction->session_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Texto de Entrada:</strong>
                            {{ $chatbotInteraction->input_text }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Metadatos de Entrada:</strong>
                            {{ $chatbotInteraction->input_metadata }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Texto de Respuesta:</strong>
                            {{ $chatbotInteraction->response_text }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Metadatos de Respuesta:</strong>
                            {{ $chatbotInteraction->response_metadata }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Intención:</strong>
                            {{ $chatbotInteraction->intent }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Sentimiento:</strong>
                            {{ $chatbotInteraction->sentiment }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Riesgo Detectado:</strong>
                            {{ $chatbotInteraction->detected_risk }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Palabras Clave Detectadas:</strong>
                            {{ $chatbotInteraction->detected_keywords }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
