@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card shadow">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card-header d-flex justify-content-between">
            <h4>Lista de usuarios</h4>
            <form action="{{ route('usuarios.index') }}" method="get" class="form-inline pull-right">
                <input id="busqueda" type="text" class="form-control" name="busqueda" value="{{ old('busqueda', request()->busqueda) }}" placeholder="Nombre o apellidos..." autofocus>
                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
            </form>
            <div class="d-flex align-right">
                <a class="btn btn-outline-warning mr-2" href="{{ route('usuarios.inactivos') }}" role="button" dusk="ver-inactivos"><i class="fas fa-user-minus"></i> Ver Inactivos</a>
                <a class="btn btn-outline-success" href="{{ route('usuarios.create') }}" role="button" dusk="crear-usuario"><i class="fas fa-plus-circle"></i> Nuevo Usuario</a>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Fotos</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombrecompleto }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>
                            {{ $usuario->roles->pluck('nombre')->implode(', ') }}
                            </td>
                            <td><img src="/storage/{{ $usuario->imagen }}" style="width:60px"></td>

                            <td class="d-flex">
                                <a href="{{ route('usuarios.show', ['usuario' => $usuario->id]) }}" class="btn btn-sm btn-info mr-2" dusk="ver-detalles-{{ $usuario->id }}"><i class="fas fa-info-circle"></i> Detalles</a>
                                <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id]) }}" class="btn btn-sm btn-secondary mr-2" dusk="editar-usuario-{{ $usuario->id }}"><i class="fas fa-user-edit"></i> Editar</a>

                                <eliminar-usuario usuario-id="{{ $usuario->id }}"></eliminar-usuario>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $usuarios->links() }}
        </div>
    </div>
</div>
@endsection
