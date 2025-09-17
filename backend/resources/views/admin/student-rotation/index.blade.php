@extends('layouts.app')

@section('template_title')
    Student Rotations
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Student Rotations') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('student-rotations.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Student Profile Id</th>
									<th >Rotation Id</th>
									<th >Assigned At</th>
									<th >Shift Type</th>
									<th >Notes</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studentRotations as $studentRotation)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $studentRotation->student_profile_id }}</td>
										<td >{{ $studentRotation->rotation_id }}</td>
										<td >{{ $studentRotation->assigned_at }}</td>
										<td >{{ $studentRotation->shift_type }}</td>
										<td >{{ $studentRotation->notes }}</td>

                                            <td>
                                                <form action="{{ route('student-rotations.destroy', $studentRotation->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('student-rotations.show', $studentRotation->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('student-rotations.edit', $studentRotation->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $studentRotations->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
