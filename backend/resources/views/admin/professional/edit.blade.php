@extends('layouts.admin')

@section('template_title')
    Actualizar Profesional
@endsection

@section('content')
<section class="content container-fluid">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <span class="card-title">Actualizar Profesional</span>
            </div>
            <div class="card-body bg-white">
                <form method="POST" action="{{ route('admin.professionals.update', $professional->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    @include('admin.professional.form')
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
