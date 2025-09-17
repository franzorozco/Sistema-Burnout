@extends('layouts.app')

@section('template_title')
    Comments
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Comments') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('comments.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Post Id</th>
									<th >User Id</th>
									<th >Parent Comment Id</th>
									<th >Body</th>
									<th >Score</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $comment->post_id }}</td>
										<td >{{ $comment->user_id }}</td>
										<td >{{ $comment->parent_comment_id }}</td>
										<td >{{ $comment->body }}</td>
										<td >{{ $comment->score }}</td>

                                            <td>
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('comments.show', $comment->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('comments.edit', $comment->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $comments->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
