@extends('layouts.admin')

@section('template_title')
    Crear Alerta del Chatbot
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Crear Alerta del Chatbot</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.chatbot-alerts.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('admin.chatbot-alert.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
