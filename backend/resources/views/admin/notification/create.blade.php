@extends('layouts.admin')

@section('template_title')
    {{ __('Crear') }} Notificación
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear') }} Notificación</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.notifications.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('admin.notification.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
