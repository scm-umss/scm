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
            <a class="btn btn-success" href="{{ route('usuarios.create') }}" role="button">Nuevo Usuario</a>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido Paterno</th>
                        <th scope="col">Apellido Materno</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Email</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->ap_paterno }}</td>
                            <td>{{ $usuario->ap_materno }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>@foreach ($usuario->roles as $rol)
                                {{ $rol->nombre }}
                            @endforeach

                            </td>
                            <td><img src="/storage/{{ $usuario->imagen }}" style="width:80px"></td>
                            <td>@if ($usuario->estado == 'a')
                                Activo
                            @else
                                Inactivo
                            @endif</td>
                            <td>

                                <form action="{{ route('usuarios.destroy', ['usuario' => $usuario->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

