@extends('layouts.app')

@section('content')


<div class="container col-md-8">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h4>Citas Pendientes</h4>
            {{-- <a class="btn btn-success" href="{{ route('especialidad.create') }}" role="button" dusk="nueva-especialidad">Nueva Especialidad</a> --}}
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
                        {{-- <th scope="col">Numero ficha</th> --}}
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Especialidad</th>
                        <th scope="col">Medico</th>
                        <th scope="col">Sucursal</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas_pendientes as $cita)
                        <tr>
                            {{-- <td>{{ $cita->numero_ficha }}</td> --}}
                            <td>{{ $cita->fecha_programada }}</td>
                            <td>{{ $cita->hora_programada }}</td>
                            <td>{{ $cita->paciente->nombre }}</td>
                            <td>{{ $cita->especialidad->nombre }}</td>
                            <td>{{ $cita->medico->nombre }}</td>
                            <td>{{ $cita->sucursal->nombre }}</td>
                            <td>{{ $cita->estado }}</td>
                            <td class="d-flex">
                                <a href="{{ route('citas.show', ['cita' => $cita->id]) }}" class="btn btn-sm btn-info mr-2" dusk="ver-detalles-{{ $cita->id }}">Ver Cita</a>
                                <a href="{{ route('citas.edit', ['cita' => $cita->id]) }}" class="btn btn-sm btn-secondary mr-2" dusk="editar-cita-{{ $cita->id }}">Editar</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $citas_pendientes->links() }}
        </div>
    </div>
</div>
@endsection

