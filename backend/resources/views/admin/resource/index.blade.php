@extends('layouts.admin')

@section('template_title')
    Recursos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Recursos') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('admin.resources.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Resumen</th>
                                        <th>Contenido</th>
                                        <th>URL</th>
                                        <th>Id del Autor</th>
                                        <th>Validado Por</th>
                                        <th>Fecha de Validación</th>
                                        <th>Etiquetas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resources as $resource)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $resource->title }}</td>
                                            <td>{{ $resource->type }}</td>
                                            <td>{{ $resource->summary }}</td>
                                            <td>{{ $resource->content }}</td>
                                            <td>{{ $resource->url }}</td>
                                            <td>{{ $resource->author_id }}</td>
                                            <td>{{ $resource->validated_by }}</td>
                                            <td>{{ $resource->validated_at }}</td>
                                            <td>{{ $resource->tags }}</td>
                                            <td>
                                                <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.resources.show', $resource->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.resources.edit', $resource->id) }}">
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
                {!! $resources->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
