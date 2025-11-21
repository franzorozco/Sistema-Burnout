@extends('layouts.admin')

@section('template_title')
    Publicaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Publicaciones') }}
                            </span>

                                                        <div class="float-right">
                                                                <a href="{{ route('admin.posts.export', request()->query()) }}" class="btn btn-secondary btn-sm me-2" data-placement="left">
                                                                    <i class="fa fa-file-pdf"></i> {{ __('Descargar PDF') }}
                                                                </a>
                                                                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
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
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="card-body bg-white">
                        <form method="GET" class="mb-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-2">
                                    <label class="form-label">Usuario</label>
                                    <input type="text" name="user_id" value="{{ request('user_id') }}" class="form-control" placeholder="User ID">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Título</label>
                                    <input type="text" name="title" value="{{ request('title') }}" class="form-control" placeholder="Título">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Anónimo</label>
                                    <select name="is_anonymous" class="form-select">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('is_anonymous') === '1' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ request('is_anonymous') === '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Limpiar</a>
                                    <a href="{{ route('admin.posts.export', request()->query()) }}" class="btn btn-outline-danger ms-auto">Descargar PDF</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Id del Usuario</th>
                                        <th>Título</th>
                                        <th>Contenido</th>
                                        <th>Es Anónimo</th>
                                        <th>Puntuación</th>
                                        <th>Vistas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $post->user_id }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->body }}</td>
                                            <td>{{ $post->is_anonymous }}</td>
                                            <td>{{ $post->score }}</td>
                                            <td>{{ $post->views }}</td>
                                            <td>
                                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.posts.show', $post->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.posts.edit', $post->id) }}">
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
                {!! $posts->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
