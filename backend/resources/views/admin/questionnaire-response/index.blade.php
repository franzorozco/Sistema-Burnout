@extends('layouts.app')

@section('template_title')
    Questionnaire Responses
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Questionnaire Responses') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('questionnaire-responses.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Questionnaire Id</th>
									<th >Student Profile Id</th>
									<th >User Id</th>
									<th >Submitted At</th>
									<th >Summary Score</th>
									<th >Raw</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questionnaireResponses as $questionnaireResponse)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $questionnaireResponse->questionnaire_id }}</td>
										<td >{{ $questionnaireResponse->student_profile_id }}</td>
										<td >{{ $questionnaireResponse->user_id }}</td>
										<td >{{ $questionnaireResponse->submitted_at }}</td>
										<td >{{ $questionnaireResponse->summary_score }}</td>
										<td >{{ $questionnaireResponse->raw }}</td>

                                            <td>
                                                <form action="{{ route('questionnaire-responses.destroy', $questionnaireResponse->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('questionnaire-responses.show', $questionnaireResponse->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('questionnaire-responses.edit', $questionnaireResponse->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $questionnaireResponses->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
