@extends('layouts.admin')

@section('template_title')
    {{ $rotation->name ?? __('Ver') . " " . __('Rotación') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Rotación</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.rotations.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $rotation->name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Ubicación:</strong>
                            {{ $rotation->location }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha de Inicio:</strong>
                            {{ $rotation->start_date }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha de Fin:</strong>
                            {{ $rotation->end_date }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Es Rural:</strong>
                            {{ $rotation->is_rural }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Detalles:</strong>
                            {{ $rotation->details }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
