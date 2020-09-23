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
            <h4>Lista de médicos</h4>
            <div class="d-flex align-right">
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
                        {{-- <th scope="col">Fotos</th> --}}
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

                            {{-- <td><img src="/storage/{{ $medico->imagen }}" style="width:60px"></td> --}}
                            <td class="d-flex">
                                <a href="{{ route('usuarios.show', ['usuario' => $medico->id]) }}" class="btn btn-sm btn-info mr-2" dusk="ver-detalles-{{ $medico->id }}">Detalles</a>
                                <a href="{{ route('usuarios.edit', ['usuario' => $medico->id]) }}" class="btn btn-sm btn-secondary mr-2" dusk="editar-medico-{{ $medico->id }}">Editar</a>

                                <eliminar-usuario usuario-id="{{ $medico->id }}"></eliminar-usuario>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

