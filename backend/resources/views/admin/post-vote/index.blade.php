@extends('layouts.admin')

@section('template_title')
    {{ __('Votos de Publicaciones') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Votos de Publicaciones') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('admin.post-votes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Usuario Id</th>
                                        <th>Publicación Id</th>
                                        <th>Comentario Id</th>
                                        <th>Voto</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($postVotes as $postVote)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $postVote->user_id }}</td>
                                            <td>{{ $postVote->post_id }}</td>
                                            <td>{{ $postVote->comment_id }}</td>
                                            <td>{{ $postVote->vote }}</td>
                                            <td>
                                                <form action="{{ route('admin.post-votes.destroy', $postVote->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.post-votes.show', $postVote->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.post-votes.edit', $postVote->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
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
                {!! $postVotes->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
