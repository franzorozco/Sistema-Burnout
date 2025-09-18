@extends('layouts.admin')

@section('template_title')
    {{ isset($file) ? __('Actualizar') : __('Crear') }} Archivo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ isset($file) ? __('Actualizar') : __('Crear') }} Archivo</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST"
                            action="{{ isset($file->id) ? route('admin.files.update', $file->id) : route('admin.files.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if(isset($file->id))
                                @method('PATCH')
                            @endif

                            @include('admin.file.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
