@extends('layouts.app')

@section('template_title')
    Chatbot Alerts
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Chatbot Alerts') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('chatbot-alerts.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Chatbot Interaction Id</th>
									<th >Student Profile Id</th>
									<th >Alert Type</th>
									<th >Severity</th>
									<th >Resolved At</th>
									<th >Resolved By</th>
									<th >Notes</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chatbotAlerts as $chatbotAlert)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $chatbotAlert->chatbot_interaction_id }}</td>
										<td >{{ $chatbotAlert->student_profile_id }}</td>
										<td >{{ $chatbotAlert->alert_type }}</td>
										<td >{{ $chatbotAlert->severity }}</td>
										<td >{{ $chatbotAlert->resolved_at }}</td>
										<td >{{ $chatbotAlert->resolved_by }}</td>
										<td >{{ $chatbotAlert->notes }}</td>

                                            <td>
                                                <form action="{{ route('chatbot-alerts.destroy', $chatbotAlert->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('chatbot-alerts.show', $chatbotAlert->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('chatbot-alerts.edit', $chatbotAlert->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $chatbotAlerts->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
