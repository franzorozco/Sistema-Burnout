@extends('layouts.admin')

@section('template_title')
    {{ $permission->name ?? __('Ver') . " " . __('Permiso') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Permiso</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.permissions.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $permission->name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Guardia:</strong>
                            {{ $permission->guard_name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
    