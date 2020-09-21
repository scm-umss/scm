@extends('layouts.app')

@section('content')


<div class="container col-md-6">

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
                        <th scope="col">Numero ficha</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Especialidad</th>
                        <th scope="col">Medico</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas_pendientes as $cita)
                        <tr>
                            <td>{{ $cita->numero_ficha }}</td>
                            <td>{{ $cita->fecha_programada }}</td>
                            <td>{{ $cita->hora_programada }}</td>
                            <td>{{ $cita->paciente->nombre }}</td>
                            <td>{{ $cita->especialidad->nombre }}</td>
                            <td>{{ $cita->medico->nombre }}</td>
                            <td>{{ $cita->estado }}</td>
                            <td>

                                {{-- <form action="{{ route('especialidad.destroy', ['especialidad' => $especialidad->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('especialidad.edit', ['especialidad' => $especialidad->id]) }}" class="btn btn-sm btn-primary" dusk="editar-especialidad-{{ $especialidad->id }}">Editar</a>
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

