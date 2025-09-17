@extends('layouts.app')

@section('template_title')
    Resources
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Resources') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('resources.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Title</th>
									<th >Type</th>
									<th >Summary</th>
									<th >Content</th>
									<th >Url</th>
									<th >Author Id</th>
									<th >Validated By</th>
									<th >Validated At</th>
									<th >Tags</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resources as $resource)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $resource->title }}</td>
										<td >{{ $resource->type }}</td>
										<td >{{ $resource->summary }}</td>
										<td >{{ $resource->content }}</td>
										<td >{{ $resource->url }}</td>
										<td >{{ $resource->author_id }}</td>
										<td >{{ $resource->validated_by }}</td>
										<td >{{ $resource->validated_at }}</td>
										<td >{{ $resource->tags }}</td>

                                            <td>
                                                <form action="{{ route('resources.destroy', $resource->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('resources.show', $resource->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('resources.edit', $resource->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $resources->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
