@extends('layouts.app')

@section('content')


<div class="col-md-6 mx-auto bg-white p-3">
    <a class="btn btn-primary float-right mb-3" href="{{ route('usuarios.create') }}" role="button">Nuevo Usuario</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido Paterno</th>
                <th scope="col">Apellido Materno</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Rol</th>
                <th scope="col">Email</th>
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
                    <td>{{ $usuario->rol }}</td>
                    <td>{{ $usuario->email }}</td>
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
@endsection

