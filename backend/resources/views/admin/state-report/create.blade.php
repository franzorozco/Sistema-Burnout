@extends('layouts.admin')

@section('template_title')
    Crear Reporte de Estado
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Crear Reporte de Estado</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.state-reports.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('admin.state-report.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
