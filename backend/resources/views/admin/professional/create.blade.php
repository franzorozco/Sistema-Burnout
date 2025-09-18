@extends('layouts.admin')

@section('template_title')
    Crear Profesional
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Crear Profesional</span>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('admin.professionals.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('admin.professional.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
