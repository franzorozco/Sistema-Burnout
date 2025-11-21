@extends('layouts.admin')

@section('template_title')
    Alertas del Chatbot
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span id="card_title">Alertas del Chatbot</span>
                    <a href="{{ route('admin.chatbot-alerts.create') }}" class="btn btn-primary btn-sm">Crear Nueva</a>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success m-4">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Interacción</th>
                                    <th>Estudiante</th>
                                    <th>Tipo de Alerta</th>
                                    <th>Severidad</th>
                                    <th>Resuelto En</th>
                                    <th>Resuelto Por</th>
                                    <th>Notas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chatbotAlerts as $chatbotAlert)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $chatbotAlert->chatbotInteraction ? $chatbotAlert->chatbotInteraction->session_id : 'N/A' }}</td>
                                    <td>{{ $chatbotAlert->studentProfile ? $chatbotAlert->studentProfile->user->name : 'N/A' }}</td>
                                    <td>{{ $chatbotAlert->alert_type }}</td>
                                    <td>{{ $chatbotAlert->severity }}</td>
                                    <td>{{ $chatbotAlert->resolved_at }}</td>
                                    <td>{{ $chatbotAlert->user ? $chatbotAlert->user->name : 'N/A' }}</td>
                                    <td>{{ $chatbotAlert->notes }}</td>
                                    <td>
                                        <form action="{{ route('admin.chatbot-alerts.destroy', $chatbotAlert->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.chatbot-alerts.show', $chatbotAlert->id) }}">Ver</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('admin.chatbot-alerts.edit', $chatbotAlert->id) }}">Editar</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="event.preventDefault(); confirm('¿Está seguro de eliminar?') ? this.closest('form').submit() : false;">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            {!! $chatbotAlerts->withQueryString()->links() !!}
        </div>
    </div>
</div>
@endsection
