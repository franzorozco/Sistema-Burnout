@extends('layouts.app')

@section('template_title')
    Questionnaire Choices
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Questionnaire Choices') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('questionnaire-choices.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Item Id</th>
									<th >Choice Order</th>
									<th >Value</th>
									<th >Label</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questionnaireChoices as $questionnaireChoice)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $questionnaireChoice->item_id }}</td>
										<td >{{ $questionnaireChoice->choice_order }}</td>
										<td >{{ $questionnaireChoice->value }}</td>
										<td >{{ $questionnaireChoice->label }}</td>

                                            <td>
                                                <form action="{{ route('questionnaire-choices.destroy', $questionnaireChoice->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('questionnaire-choices.show', $questionnaireChoice->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('questionnaire-choices.edit', $questionnaireChoice->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $questionnaireChoices->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
