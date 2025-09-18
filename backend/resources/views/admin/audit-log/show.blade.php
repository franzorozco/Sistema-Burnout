@extends('layouts.admin')

@section('template_title')
    {{ $auditLog->name ?? __('Ver') . " " . __('Registro de Auditoría') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Registro de Auditoría</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.audit-logs.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Usuario:</strong>
                            {{ $auditLog->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Acción:</strong>
                            {{ $auditLog->action }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tabla:</strong>
                            {{ $auditLog->table_name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>ID del Registro:</strong>
                            {{ $auditLog->record_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Datos Anteriores:</strong>
                            {{ $auditLog->old_data }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Datos Nuevos:</strong>
                            {{ $auditLog->new_data }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>IP:</strong>
                            {{ $auditLog->ip_address }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Agente de Usuario:</strong>
                            {{ $auditLog->user_agent }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
