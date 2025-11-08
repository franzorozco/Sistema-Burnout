@extends('layouts.admin')

@section('template_title')
    Ítems de Cuestionario
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Ítems de Cuestionario') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('admin.questionnaire-items.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Cuestionario</th>
                                        <th>Orden del Ítem</th>
                                        <th>Pregunta</th>
                                        <th>Tipo de Respuesta</th>
                                        <th>Meta</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questionnaireItems as $questionnaireItem)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $questionnaireItem->questionnaire_id }}</td>
                                            <td>{{ $questionnaireItem->item_order }}</td>
                                            <td>{{ $questionnaireItem->question_text }}</td>
                                            <td>{{ $questionnaireItem->response_type }}</td>
                                            <td>
                                                @php
                                                    $meta = json_decode($questionnaireItem->meta, true);
                                                @endphp

                                                @if(isset($meta['choices']) && is_array($meta['choices']))
                                                    <ul class="mb-0">
                                                        @foreach($meta['choices'] as $choice)
                                                            <li>{{ $choice['label'] ?? $choice['value'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{ $questionnaireItem->meta }}
                                                @endif
                                            </td>

                                            <td>
                                                <form action="{{ route('admin.questionnaire-items.destroy', $questionnaireItem->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.questionnaire-items.show', $questionnaireItem->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.questionnaire-items.edit', $questionnaireItem->id) }}">
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
                {!! $questionnaireItems->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
