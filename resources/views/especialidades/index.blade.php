@extends('layouts.app')

@section('content')


<div class="col-md-10 mx-auto bg-white p-3">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($especialidades as $especialidad)
                <tr>
                    <td>{{ $especialidad->id }}</td>
                    <td>{{ $especialidad->descripcion }}</td>
                    <td>
                        <a href="{{ route('especialidades.edit', ['especialidad' => $especialidad->id]) }}">Editar</a>
                        <form action="{{ route('especialidades.destroy', ['especialidad' => $especialidad->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary">Eliminar</button>
                            </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

