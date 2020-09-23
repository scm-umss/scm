@extends('layouts.app')

@section('content')


<div class="container col-md-6">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h4>Lista de Roles</h4>
            <a class="btn btn-success" href="{{ route('rol.create') }}" role="button">Nuevo Rol</a>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr>
                            <td>{{ $rol->id }}</td>
                            <td>{{ $rol->nombre }}</td>
                            <td>{{ $rol->slug }}</td>
                            <td>{{ $rol->descripcion }}</td>
                            <td>

                                <form action="{{ route('rol.destroy', ['rol' => $rol->id]) }}"
                                    method="POST" class="d-inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('rol.edit', ['rol' => $rol->id]) }}" class="btn btn-sm btn-primary mr-2">Editar</a>
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

