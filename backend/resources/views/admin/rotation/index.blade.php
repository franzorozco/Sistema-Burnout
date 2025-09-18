@extends('layouts.admin')

@section('template_title')
    Rotaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Rotaciones') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('admin.rotations.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Nombre</th>
                                        <th>Ubicación</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Es Rural</th>
                                        <th>Detalles</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rotations as $rotation)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $rotation->name }}</td>
                                            <td>{{ $rotation->location }}</td>
                                            <td>{{ $rotation->start_date }}</td>
                                            <td>{{ $rotation->end_date }}</td>
                                            <td>{{ $rotation->is_rural }}</td>
                                            <td>{{ $rotation->details }}</td>

                                            <td>
                                                <form action="{{ route('admin.rotations.destroy', $rotation->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.rotations.show', $rotation->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.rotations.edit', $rotation->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar esta rotación?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $rotations->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
