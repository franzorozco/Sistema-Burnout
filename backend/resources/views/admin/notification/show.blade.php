@extends('layouts.admin')

@section('template_title')
    {{ $notification->name ?? __('Ver') . " " . __('Notificación') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Notificación</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.notifications.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Usuario:</strong>
                            {{ $notification->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo:</strong>
                            {{ $notification->type }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Contenido:</strong>
                            {{ $notification->payload }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Leído:</strong>
                            {{ $notification->is_read ? __('Sí') : __('No') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
