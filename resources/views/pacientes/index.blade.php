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
            <h4>Lista de pacientes</h4>
            <div class="d-flex align-right">
                <a class="btn btn-outline-warning mr-2" href="{{ route('usuarios.inactivos') }}" role="button" dusk="ver-inactivos"><i class="fas fa-user-minus"></i> Ver Inactivos</a>
                <a class="btn btn-outline-success" href="{{ route('usuarios.create') }}" role="button" dusk="crear-paciente"><i class="fas fa-plus-circle"></i> Nuevo Paciente</a>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Fotos</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->nombreCompleto }}</td>
                            <td>{{ $paciente->telefono }}</td>

                            <td><img src="/storage/{{ $paciente->imagen }}" style="width:60px"></td>
                            <td class="d-flex">
                                <a href="{{ route('usuarios.show', ['usuario' => $paciente->id]) }}" class="btn btn-sm btn-info mr-2" dusk="ver-detalles-{{ $paciente->id }}"><i class="fas fa-info-circle"></i> Detalles</a>
                                <a href="{{ route('usuarios.edit', ['usuario' => $paciente->id]) }}" class="btn btn-sm btn-secondary mr-2" dusk="editar-paciente-{{ $paciente->id }}"><i class="fas fa-user-edit"></i> Editar</a>
                                <a href="{{ route('citas.agendar', $paciente->id) }}" class="btn btn-sm btn-dark mr-2">Agendar cita</a>

                                <eliminar-usuario usuario-id="{{ $paciente->id }}"></eliminar-usuario>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $pacientes->links() }}
        </div>
    </div>
</div>
@endsection

