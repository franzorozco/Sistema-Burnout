@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Post Vote
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Post Vote</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('post-votes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('post-vote.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
