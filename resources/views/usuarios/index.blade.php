@extends('layouts.app')

@section('content')
{{-- {{ dd($u->roles()->nombre) }} --}}

<div class="container col-md-8">
    <div class="card shadow">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card-header d-flex justify-content-between">
            <h4>Lista de usuarios</h4>
            <div class="d-flex align-right">
                <a class="btn btn-warning mr-2" href="{{ route('usuarios.inactivos') }}" role="button" dusk="ver-inactivos">Ver Inactivos</a>
                <a class="btn btn-success" href="{{ route('usuarios.create') }}" role="button" dusk="crear-usuario">Nuevo Usuario</a>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre Completo</th>
                        {{-- <th scope="col">Apellido Paterno</th>
                        <th scope="col">Apellido Materno</th> --}}
                        <th scope="col">Teléfono</th>
                        <th scope="col">Roles</th>
                        {{-- <th scope="col">Email</th> --}}
                        {{-- <th scope="col">Estado</th> --}}
                        <th scope="col">Fotos</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombre }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>@foreach ($usuario->roles as $rol)
                                {{ $rol->nombre }}
                            @endforeach
                            </td>
                            {{-- <td>@if ($usuario->estado == 'a')
                                    Activo
                                @else
                                    Inactivo
                                @endif
                            </td> --}}

                            <td><img src="/storage/{{ $usuario->imagen }}" style="width:60px"></td>
                            <td>

                                {{-- <form action="{{ route('usuarios.destroy', ['usuario' => $usuario->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form> --}}
                                <a href="{{ route('usuarios.show', ['usuario' => $usuario->id]) }}" class="btn btn-sm btn-info">Detalles</a>
                                <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id]) }}" class="btn btn-sm btn-secondary" dusk="editar-usuario-{{ $usuario->id }}">Editar</a>
                                <a href="{{ route('usuarios.destroy', $usuario->id) }}" class="btn btn-sm btn-danger" dusk="eliminar-usuario-{{ $usuario->id }}" >Eliminar</a>
                                {{-- <button type="submit" class="btn btn-sm btn-danger">Eliminar</button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

