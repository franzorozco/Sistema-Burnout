@extends('layouts.admin')

@section('template_title')
    Notificaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Notificaciones') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                  {{ __('Crear nueva') }}
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
                                        
                                        <th>Usuario</th>
                                        <th>Tipo</th>
                                        <th>Contenido</th>
                                        <th>Leído</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
                                            <td>{{ $notification->user_id }}</td>
                                            <td>{{ $notification->type }}</td>
                                            <td>{{ $notification->payload }}</td>
                                            <td>{{ $notification->is_read ? __('Sí') : __('No') }}</td>

                                            <td>
                                                <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.notifications.show', $notification->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.notifications.edit', $notification->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $notifications->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
