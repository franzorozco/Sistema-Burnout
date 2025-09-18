@extends('layouts.admin')

@section('template_title')
    {{ $studentRotation->name ?? __('Mostrar') . " " . __('Rotación de Estudiante') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Rotación de Estudiante</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.student-rotations.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Id Perfil de Estudiante:</strong>
                            {{ $studentRotation->student_profile_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Id Rotación:</strong>
                            {{ $studentRotation->rotation_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Asignado En:</strong>
                            {{ $studentRotation->assigned_at }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo de Turno:</strong>
                            {{ $studentRotation->shift_type }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Notas:</strong>
                            {{ $studentRotation->notes }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
