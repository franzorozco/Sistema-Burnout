@extends('layouts.admin')

@section('template_title')
    Actualizar Alerta del Chatbot
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Actualizar Alerta del Chatbot</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.chatbot-alerts.update', $chatbotAlert->id) }}" role="form" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf

                            @include('admin.chatbot-alert.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
