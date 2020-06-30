@extends('layouts.app')

@section('content')


<div class="col-md-6 mx-auto bg-white p-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($especialidades as $especialidad)
                <tr>
                    <td>{{ $especialidad->id }}</td>
                    <td>{{ $especialidad->nombre }}</td>
                    <td>{{ $especialidad->descripcion }}</td>
                    <td>

                        <form action="{{ route('especialidades.destroy', ['especialidad' => $especialidad->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('especialidades.edit', ['especialidad' => $especialidad->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

