@extends('layouts.admin')

@section('template_title')
    Alerta del Chatbot
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="card-title">Ver Alerta del Chatbot</span>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.chatbot-alerts.index') }}">Volver</a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="form-group mb-2">
                        <strong>Id Interacción:</strong>
                        {{ $chatbotAlert->chatbot_interaction_id }}
                    </div>
                    <div class="form-group mb-2">
                        <strong>Id Perfil Estudiante:</strong>
                        {{ $chatbotAlert->student_profile_id }}
                    </div>
                    <div class="form-group mb-2">
                        <strong>Tipo de Alerta:</strong>
                        {{ $chatbotAlert->alert_type }}
                    </div>
                    <div class="form-group mb-2">
                        <strong>Severidad:</strong>
                        {{ $chatbotAlert->severity }}
                    </div>
                    <div class="form-group mb-2">
                        <strong>Resuelto En:</strong>
                        {{ $chatbotAlert->resolved_at }}
                    </div>
                    <div class="form-group mb-2">
                        <strong>Resuelto Por:</strong>
                        {{ $chatbotAlert->resolved_by }}
                    </div>
                    <div class="form-group mb-2">
                        <strong>Notas:</strong>
                        {{ $chatbotAlert->notes }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
