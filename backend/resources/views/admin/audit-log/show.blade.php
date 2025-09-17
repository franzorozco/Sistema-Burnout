@extends('layouts.app')

@section('template_title')
    {{ $auditLog->name ?? __('Show') . " " . __('Audit Log') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Audit Log</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('audit-logs.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $auditLog->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Action:</strong>
                                    {{ $auditLog->action }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Table Name:</strong>
                                    {{ $auditLog->table_name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Record Id:</strong>
                                    {{ $auditLog->record_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Old Data:</strong>
                                    {{ $auditLog->old_data }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>New Data:</strong>
                                    {{ $auditLog->new_data }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Ip Address:</strong>
                                    {{ $auditLog->ip_address }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>User Agent:</strong>
                                    {{ $auditLog->user_agent }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
