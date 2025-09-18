@extends('layouts.admin')

@section('template_title')
    Opciones de Cuestionario
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Opciones de Cuestionario') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('admin.questionnaire-choices.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nueva') }}
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
                                        <th>Id del Ítem</th>
                                        <th>Orden de la Opción</th>
                                        <th>Valor</th>
                                        <th>Etiqueta</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questionnaireChoices as $questionnaireChoice)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $questionnaireChoice->item_id }}</td>
                                            <td>{{ $questionnaireChoice->choice_order }}</td>
                                            <td>{{ $questionnaireChoice->value }}</td>
                                            <td>{{ $questionnaireChoice->label }}</td>
                                            <td>
                                                <form action="{{ route('admin.questionnaire-choices.destroy', $questionnaireChoice->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.questionnaire-choices.show', $questionnaireChoice->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.questionnaire-choices.edit', $questionnaireChoice->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar?') ? this.closest('form').submit() : false;">
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
                {!! $questionnaireChoices->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
