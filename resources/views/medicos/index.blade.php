@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card shadow">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-danger">
                {{ session('info') }}
            </div>
            @endif
        <div class="card-header d-flex justify-content-between">
            <h4>Lista de médicos</h4>
            <div class="d-flex align-right">
                <a class="btn btn-warning mr-2" href="{{ route('usuarios.inactivos') }}" role="button" dusk="ver-inactivos">Ver Inactivos</a>
                <a class="btn btn-success" href="{{ route('usuarios.create') }}" role="button" dusk="crear-medico">Nuevo Médico</a>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Especialidades</th>
                        <th scope="col">Fotos</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicos as $medico)
                        <tr>
                            <td>{{ $medico->nombreCompleto }}</td>
                            <td>{{ $medico->telefono }}</td>
                            <td>{{ $medico->especialidades->pluck('nombre')->implode(', ') }}
                            </td>

                            <td><img src="/storage/{{ $medico->imagen }}" style="width:60px"></td>
                            <td class="d-flex">
                                <a href="{{ route('usuarios.show', ['usuario' => $medico->id]) }}" class="btn btn-sm btn-info mr-2" dusk="ver-detalles-{{ $medico->id }}">Perfil</a>
                                <a href="{{ route('horarios.edit', ['medico' => $medico->id]) }}" class="btn btn-sm btn-dark mr-2" dusk="horario-medico-{{ $medico->id }}">Asignar horario</a>
                                <a href="{{ route('usuarios.edit', ['usuario' => $medico->id]) }}" class="btn btn-sm btn-secondary mr-2" dusk="editar-medico-{{ $medico->id }}">Editar</a>

                                <eliminar-usuario usuario-id="{{ $medico->id }}"></eliminar-usuario>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $medicos->links() }}
        </div>
    </div>
</div>
@endsection

