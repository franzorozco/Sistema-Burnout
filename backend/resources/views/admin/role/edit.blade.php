@extends('layouts.admin')

@section('template_title')
    {{ __('Actualizar') }} Rol
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Rol</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.roles.update', $role->id) }}"  role="form" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf

                            @include('admin.role.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
