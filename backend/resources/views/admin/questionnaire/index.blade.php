@extends('layouts.admin')

@section('template_title')
    Cuestionarios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Cuestionarios') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('admin.questionnaires.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Código</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Versión</th>
                                        <th>Creado Por</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questionnaires as $questionnaire)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $questionnaire->code }}</td>
                                            <td>{{ $questionnaire->title }}</td>
                                            <td>{{ $questionnaire->description }}</td>
                                            <td>{{ $questionnaire->version }}</td>
                                            <td>{{ $questionnaire->created_by }}</td>
                                            <td>
                                                <form action="{{ route('admin.questionnaires.destroy', $questionnaire->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.questionnaires.show', $questionnaire->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.questionnaires.edit', $questionnaire->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Seguro que desea eliminar?') ? this.closest('form').submit() : false;">
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
                {!! $questionnaires->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
