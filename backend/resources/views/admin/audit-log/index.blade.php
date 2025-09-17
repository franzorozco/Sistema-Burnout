@extends('layouts.app')

@section('template_title')
    Audit Logs
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Audit Logs') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('audit-logs.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >User Id</th>
									<th >Action</th>
									<th >Table Name</th>
									<th >Record Id</th>
									<th >Old Data</th>
									<th >New Data</th>
									<th >Ip Address</th>
									<th >User Agent</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($auditLogs as $auditLog)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $auditLog->user_id }}</td>
										<td >{{ $auditLog->action }}</td>
										<td >{{ $auditLog->table_name }}</td>
										<td >{{ $auditLog->record_id }}</td>
										<td >{{ $auditLog->old_data }}</td>
										<td >{{ $auditLog->new_data }}</td>
										<td >{{ $auditLog->ip_address }}</td>
										<td >{{ $auditLog->user_agent }}</td>

                                            <td>
                                                <form action="{{ route('audit-logs.destroy', $auditLog->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('audit-logs.show', $auditLog->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('audit-logs.edit', $auditLog->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $auditLogs->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
