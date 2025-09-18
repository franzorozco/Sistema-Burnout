@extends('layouts.admin')

@section('template_title')
    Comentarios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Comentarios') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('admin.comments.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                  {{ __('Crear Nuevo') }}
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
                                        <th>Id del Post</th>
                                        <th>Id del Usuario</th>
                                        <th>Id del Comentario Padre</th>
                                        <th>Contenido</th>
                                        <th>Puntuación</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $comment->post_id }}</td>
                                            <td>{{ $comment->user_id }}</td>
                                            <td>{{ $comment->parent_comment_id }}</td>
                                            <td>{{ $comment->body }}</td>
                                            <td>{{ $comment->score }}</td>
                                            <td>
                                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.comments.show', $comment->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.comments.edit', $comment->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;">
                                                        <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                    </button>
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
