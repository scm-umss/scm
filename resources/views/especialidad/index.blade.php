@extends('layouts.app')

@section('content')


<div class="container col-md-8">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h4>Especialidades</h4>
            <div class="d-flex align-right">
                <especialidades-inactivos></especialidades-inactivos>
                <a class="btn btn-outline-success" href="{{ route('especialidad.create') }}" role="button" dusk="nueva-especialidad"><i class="fas fa-plus-circle"></i> Nueva Especialidad</a>
            </div>
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
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('especialidad.edit', ['especialidad' => $especialidad->id]) }}" class="btn btn-sm btn-secondary mr-2" dusk="editar-especialidad-{{ $especialidad->id }}"><i class="fas fa-pen"></i> Editar</a>
                                <eliminar-especialidad especialidad-id="{{ $especialidad->id }}"></eliminar-especialidad>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
