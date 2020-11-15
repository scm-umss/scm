@extends('layouts.app')

@section('content')

<div class="container col-md-8">
    <div class="card shadow">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card-header d-flex justify-content-between">
            <h4>Usuarios inactivos</h4>
            <a class="btn btn-warning mr-2" href="{{ route('usuarios.index') }}" role="button" dusk="ver-activos">Ver Activos</a>
        </div>
        <div class="card-body">

            <table class="table table-striped">
               @if ($usuarios->count())
               <thead>
                <tr>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Roles</th>
                    {{-- <th scope="col">Fotos</th> --}}
                    <th scope="col">Acciones</th>

                </tr>
            </thead>
               @endif
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombreCompleto }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>@foreach ($usuario->roles as $rol)
                                {{ $rol->nombre }}
                            @endforeach
                            </td>

                            {{-- <td><img src="/storage/{{ $usuario->imagen }}" style="width:60px"></td> --}}
                            <td>
                                <a href="{{ route('usuarios.restore', $usuario->id) }}" class="btn btn-sm btn-secondary" dusk="restaurar-usuario-{{ $usuario->id }}"> Restaurar</a>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-info" role="alert">
                            <p class="display-4">Aún no existen usuarios inactivos!.</p>
                          </div>


                </tbody>
            </table>

        @endforelse
        </div>
    </div>
</div>
@endsection

