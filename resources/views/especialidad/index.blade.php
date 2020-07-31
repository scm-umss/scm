@extends('layouts.app')

@section('content')


<div class="container col-md-6">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h4>Especialidades</h4>
            <a class="btn btn-success" href="{{ route('especialidad.create') }}" role="button" dusk="nueva-especialidad">Nueva Especialidad</a>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
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

                                <form action="{{ route('especialidad.destroy', ['especialidad' => $especialidad->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('especialidad.edit', ['especialidad' => $especialidad->id]) }}" class="btn btn-sm btn-primary" dusk="editar-especialidad-{{ $especialidad->id }}">Editar</a>
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

