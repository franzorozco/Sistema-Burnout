@extends('layouts.app')

@section('template_title')
    Student Profiles
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Student Profiles') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('student-profiles.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
									<th >Student Code</th>
									<th >Birthdate</th>
									<th >Career</th>
									<th >Semester</th>
									<th >Group Name</th>
									<th >Consent Given</th>
									<th >Consent At</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studentProfiles as $studentProfile)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $studentProfile->user_id }}</td>
										<td >{{ $studentProfile->student_code }}</td>
										<td >{{ $studentProfile->birthdate }}</td>
										<td >{{ $studentProfile->career }}</td>
										<td >{{ $studentProfile->semester }}</td>
										<td >{{ $studentProfile->group_name }}</td>
										<td >{{ $studentProfile->consent_given }}</td>
										<td >{{ $studentProfile->consent_at }}</td>

                                            <td>
                                                <form action="{{ route('student-profiles.destroy', $studentProfile->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('student-profiles.show', $studentProfile->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('student-profiles.edit', $studentProfile->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $studentProfiles->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
