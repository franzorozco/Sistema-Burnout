@extends('layouts.app')

@section('template_title')
    Files
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Files') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('files.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Owner User Id</th>
									<th >Related Type</th>
									<th >Related Id</th>
									<th >Filename</th>
									<th >Url</th>
									<th >Mime Type</th>
									<th >Size Bytes</th>
									<th >Checksum</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $file->owner_user_id }}</td>
										<td >{{ $file->related_type }}</td>
										<td >{{ $file->related_id }}</td>
										<td >{{ $file->filename }}</td>
										<td >{{ $file->url }}</td>
										<td >{{ $file->mime_type }}</td>
										<td >{{ $file->size_bytes }}</td>
										<td >{{ $file->checksum }}</td>

                                            <td>
                                                <form action="{{ route('files.destroy', $file->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('files.show', $file->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('files.edit', $file->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $files->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
