@extends('layouts.app')

@section('template_title')
    Questionnaires
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Questionnaires') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('questionnaires.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Code</th>
									<th >Title</th>
									<th >Description</th>
									<th >Version</th>
									<th >Created By</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questionnaires as $questionnaire)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $questionnaire->code }}</td>
										<td >{{ $questionnaire->title }}</td>
										<td >{{ $questionnaire->description }}</td>
										<td >{{ $questionnaire->version }}</td>
										<td >{{ $questionnaire->created_by }}</td>

                                            <td>
                                                <form action="{{ route('questionnaires.destroy', $questionnaire->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('questionnaires.show', $questionnaire->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('questionnaires.edit', $questionnaire->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $questionnaires->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
