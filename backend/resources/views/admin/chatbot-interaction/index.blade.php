@extends('layouts.app')

@section('template_title')
    Chatbot Interactions
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Chatbot Interactions') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('chatbot-interactions.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
									<th >Session Id</th>
									<th >Input Text</th>
									<th >Input Metadata</th>
									<th >Response Text</th>
									<th >Response Metadata</th>
									<th >Intent</th>
									<th >Sentiment</th>
									<th >Detected Risk</th>
									<th >Detected Keywords</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chatbotInteractions as $chatbotInteraction)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $chatbotInteraction->user_id }}</td>
										<td >{{ $chatbotInteraction->session_id }}</td>
										<td >{{ $chatbotInteraction->input_text }}</td>
										<td >{{ $chatbotInteraction->input_metadata }}</td>
										<td >{{ $chatbotInteraction->response_text }}</td>
										<td >{{ $chatbotInteraction->response_metadata }}</td>
										<td >{{ $chatbotInteraction->intent }}</td>
										<td >{{ $chatbotInteraction->sentiment }}</td>
										<td >{{ $chatbotInteraction->detected_risk }}</td>
										<td >{{ $chatbotInteraction->detected_keywords }}</td>

                                            <td>
                                                <form action="{{ route('chatbot-interactions.destroy', $chatbotInteraction->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('chatbot-interactions.show', $chatbotInteraction->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('chatbot-interactions.edit', $chatbotInteraction->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $chatbotInteractions->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
