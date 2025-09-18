@extends('layouts.admin')

@section('template_title')
    Perfiles de Estudiantes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Perfiles de Estudiantes') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('admin.student-profiles.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Id de Usuario</th>
                                        <th>Código de Estudiante</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Carrera</th>
                                        <th>Semestre</th>
                                        <th>Nombre del Grupo</th>
                                        <th>Consentimiento</th>
                                        <th>Fecha de Consentimiento</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studentProfiles as $studentProfile)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $studentProfile->user_id }}</td>
                                            <td>{{ $studentProfile->student_code }}</td>
                                            <td>{{ $studentProfile->birthdate }}</td>
                                            <td>{{ $studentProfile->career }}</td>
                                            <td>{{ $studentProfile->semester }}</td>
                                            <td>{{ $studentProfile->group_name }}</td>
                                            <td>{{ $studentProfile->consent_given }}</td>
                                            <td>{{ $studentProfile->consent_at }}</td>

                                            <td>
                                                <form action="{{ route('admin.student-profiles.destroy', $studentProfile->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.student-profiles.show', $studentProfile->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.student-profiles.edit', $studentProfile->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar este perfil?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $studentProfiles->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
