@extends('layouts.admin')

@section('template_title')
    {{ __('Archivos') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span id="card_title">{{ __('Archivos') }}</span>
                        <a href="{{ route('admin.files.create') }}" class="btn btn-primary btn-sm">{{ __('Crear nuevo') }}</a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Usuario dueño</th>
                                        <th>Tipo relacionado</th>
                                        <th>ID relacionado</th>
                                        <th>Nombre de archivo</th>
                                        <th>URL</th>
                                        <th>Tipo MIME</th>
                                        <th>Tamaño (bytes)</th>
                                        <th>Checksum</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $file->owner_user_id }}</td>
                                            <td>{{ $file->related_type }}</td>
                                            <td>{{ $file->related_id }}</td>
                                            <td>{{ $file->filename }}</td>
                                            <td>{{ $file->url }}</td>
                                            <td>{{ $file->mime_type }}</td>
                                            <td>{{ $file->size_bytes }}</td>
                                            <td>{{ $file->checksum }}</td>
                                            <td>
                                                <form action="{{ route('admin.files.destroy', $file->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.files.show', $file->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.files.edit', $file->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('{{ __('¿Está seguro de eliminar?') }}') ? this.closest('form').submit() : false;">
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
                {!! $files->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
