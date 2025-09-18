@extends('layouts.admin')

@section('template_title')
    Crear Interacción del Chatbot
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Crear Interacción del Chatbot</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('admin.chatbot-interactions.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('admin.chatbot-interaction.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
