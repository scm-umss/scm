@extends('citas.index')

@section('cabecera','Citas Pendientes')

@section('citas')
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                {{-- <th scope="col">Numero ficha</th> --}}
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Especialidad</th>
                @if ($rol == 'paciente')
                    <th scope="col">Médico</th>
                @elseif ($rol == 'medico')
                    <th scope="col">Paciente</th>
                @else
                <th scope="col">Médico</th>
                <th scope="col">Paciente</th>
                @endif
                <th scope="col">Sucursal</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas_pendientes as $cita)
                <tr>
                    <td>{{ $cita->fecha_programada->format('d-m-Y') }}</td>
                    <td>{{ $cita->hora_programada }}</td>
                    <td>{{ $cita->especialidad->nombre }}</td>
                    @if ($rol == 'paciente')
                        <td>{{ $cita->medico->nombreCompleto }}</td>
                    @elseif ($rol == 'medico')
                        <td>{{ $cita->paciente->nombreCompleto }}</td>
                    @else
                    <td>{{ $cita->medico->nombreCompleto }}</td>
                    <td>{{ $cita->paciente->nombreCompleto }}</td>
                    @endif
                    <td>{{ $cita->sucursal->nombre }}</td>
                    <td class="d-flex">
                        @if ($rol == 'admin')
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('citas.show', $cita->id) }}" dusk="ver-cita-{{ $cita->id }}">
                              Ver
                          </a>
                          <a class="btn btn-sm btn-secondary mr-2" href="{{ route('citas.edit', $cita->id) }}" dusk="editar-cita-{{ $cita->id }}">
                              Editar
                          </a>
                        @endif

                        @if ($rol == 'medico' || $rol == 'admin')
                          <form action="{{ route('citas.confirmar',$cita->id) }}"
                            method="POST" class="d-inline-block mr-2">
                            @csrf

                            <button class="btn btn-sm btn-success" type="submit" dusk="confirmar-cita-{{ $cita->id }}">
                              Confirmar
                            </button>
                          </form>
                        @endif

                        <cancelar-cita cita-id="{{ $cita->id }}" />
                      </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $citas_pendientes->links() }}
</div>
@endsection
