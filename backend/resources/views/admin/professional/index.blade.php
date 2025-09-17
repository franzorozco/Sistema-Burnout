@extends('layouts.app')

@section('template_title')
    Professionals
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Professionals') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('professionals.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
									<th >Profession</th>
									<th >License Number</th>
									<th >Bio</th>
									<th >Is Available</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($professionals as $professional)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $professional->user_id }}</td>
										<td >{{ $professional->profession }}</td>
										<td >{{ $professional->license_number }}</td>
										<td >{{ $professional->bio }}</td>
										<td >{{ $professional->is_available }}</td>

                                            <td>
                                                <form action="{{ route('professionals.destroy', $professional->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('professionals.show', $professional->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('professionals.edit', $professional->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $professionals->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
