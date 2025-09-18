@extends('layouts.app')

@section('template_title')
    {{ __('Actualizar') }} Archivo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="card-title">{{ __('Actualizar') }} Archivo</span>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.files.index') }}"> {{ __('Volver') }}</a>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.files.update', $file->id) }}" role="form" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf

                            @include('admin.file.form')

                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">{{ __('Guardar cambios') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
