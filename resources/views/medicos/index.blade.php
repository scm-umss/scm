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
                        <th scope="col">Fotos</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicos as $medico)
                        <tr>
                            <td>{{ $medico->nombre }} {{ $medico->ap_paterno }} {{ $medico->ap_materno }}</td>
                            <td>{{ $medico->telefono }}</td>
                            <td>@foreach ($medico->especialidades as $especialidad)
                                {{ $especialidad->nombre }}
                            @endforeach
                            </td>

                            <td><img src="/storage/{{ $medico->imagen }}" style="width:60px"></td>
                            <td>
                                <a href="{{ route('horarios.edit', $medico->id) }}" class="btn btn-sm btn-info" dusk="ver-horarios-{{ $medico->id }}">Ver Horarios</a>
                                {{-- <a href="{{ route('usuarios.show', ['usuario' => $medico->id]) }}" class="btn btn-sm btn-info" dusk="ver-detalles-{{ $medico->id }}">Detalles</a>
                                <a href="{{ route('usuarios.edit', ['usuario' => $medico->id]) }}" class="btn btn-sm btn-secondary" dusk="editar-medico-{{ $medico->id }}">Editar</a>
                                <a href="{{ route('usuarios.destroy', $medico->id) }}" class="btn btn-sm btn-danger" dusk="eliminar-medico-{{ $medico->id }}" >Eliminar</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

