@extends('layouts.admin')

@section('template_title')
    {{ $role->name ?? __('Ver') . " " . __('Rol') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Rol</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $role->name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Guardia:</strong>
                            {{ $role->guard_name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Descripción:</strong>
                            {{ $role->description }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Creado Por:</strong>
                            {{ $role->created_by }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
