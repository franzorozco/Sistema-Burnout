@extends('layouts.admin')

@section('template_title')
    Respuestas de Cuestionario
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Respuestas de Cuestionario
                            </span>

                             <div class="float-right">
                                <a href="{{ route('admin.questionnaire-responses.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                  Crear Nueva
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
                                        <th>Cuestionario</th>
                                        <th>Perfil Estudiante</th>
                                        <th>Usuario</th>
                                        <th>Enviado En</th>
                                        <th>Puntuación Resumen</th>
                                        <th>Datos Crudos</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questionnaireResponses as $questionnaireResponse)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $questionnaireResponse->questionnaire_id }}</td>
                                            <td>{{ $questionnaireResponse->student_profile_id }}</td>
                                            <td>{{ $questionnaireResponse->user_id }}</td>
                                            <td>{{ $questionnaireResponse->submitted_at }}</td>
                                            <td>{{ $questionnaireResponse->summary_score }}</td>
                                            <td>{{ $questionnaireResponse->raw }}</td>
                                            <td>
                                                <form action="{{ route('admin.questionnaire-responses.destroy', $questionnaireResponse->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.questionnaire-responses.show', $questionnaireResponse->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> Ver
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.questionnaire-responses.edit', $questionnaireResponse->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> Editar
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar?') ? this.closest('form').submit() : false;">
                                                        <i class="fa fa-fw fa-trash"></i> Eliminar
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
                {!! $questionnaireResponses->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
