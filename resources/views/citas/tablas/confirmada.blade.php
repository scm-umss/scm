@extends('citas.index')

@section('cabecera','Citas Confirmadas')

@section('citas')
<div class="table-responsive">
    @if ($citas_confirmadas->count())

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Especialidad</th>
                @if ($rol == 'paciente')
                    <th scope="col">Médico</th>
                @elseif ($rol == 'medico')
                    <th scope="col">Paciente</th>
                @elseif ($rol == 'admin')
                    <th scope="col">Paciente</th>
                    <th scope="col">Médico</th>
                @endif
                <th scope="col">Sucursal</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas_confirmadas as $cita)
            <tr>
                <td>{{ $cita->fecha_programada->format('d-m-Y') }}</td>
                <td>{{ $cita->hora_programada }}</td>
                <td>{{ $cita->especialidad->nombre }}</td>
                @if ($rol == 'paciente')
                        <td>{{ $cita->medico->nombreCompleto }}</td>
                @elseif ($rol == 'medico')
                        <td>{{ $cita->paciente->nombreCompleto }}</td>
                @elseif($rol == 'admin')
                        <td>{{ $cita->paciente->nombreCompleto }}</td>
                        <td>{{ $cita->medico->nombreCompleto }}</td>
                @endif
                <td>{{ $cita->sucursal->nombre }}</td>
                <td class="d-flex">
                    @if ($rol == 'admin')
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('citas.show', $cita->id) }}">
                        Ver
                    </a>
                    @endif
                    @if (($rol == 'medico' || $rol == 'admin') && ($cita->fecha_programada->format('Y-m-d') <= $fecha_actual))
                        <form action="{{ route('citas.atendido',$cita->id) }}"
                        method="POST" class="d-inline-block mr-2">
                        @csrf

                        <button class="btn btn-sm btn-success" type="submit" dusk="atender-cita-{{ $cita->id }}">
                            Atendido
                        </button>
                        </form>
                    @endif
                    <cancelar-cita cita-id="{{ $cita->id }}" />
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $citas_confirmadas->links() }}
    @else
    <p>Aún no tiene citas confirmadas</p>
    @endif
</div>

@endsection
