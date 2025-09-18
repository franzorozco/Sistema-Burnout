@extends('layouts.admin')

@section('template_title')
    {{ $professional->name ?? __('Ver') . " " . __('Profesional') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Profesional</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.professionals.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Id de Usuario:</strong>
                            {{ $professional->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Profesión:</strong>
                            {{ $professional->profession }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Número de Licencia:</strong>
                            {{ $professional->license_number }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Biografía:</strong>
                            {{ $professional->bio }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Disponible:</strong>
                            {{ $professional->is_available ? 'Sí' : 'No' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
