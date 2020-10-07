<div class="table-responsive">
    @if ($citas_confirmadas->count())

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
                @endif
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas_confirmadas as $cita)
            <tr>
                <td>{{ $cita->fecha_programada }}</td>
                <td>{{ $cita->hora_programada }}</td>
                <td>{{ $cita->especialidad->nombre }}</td>
                @if ($rol == 'paciente')
                    <td>{{ $cita->medico->nombreCompleto }}</td>
                @elseif ($rol == 'medico')
                    <td>{{ $cita->paciente->nombre }}</td>
                @endif
                <td>
                    @if ($rol == 'admin')
                    <a class="btn btn-sm btn-primary" href="{{ route('citas.show', $cita->id) }}">
                        Ver cita
                    </a>
                    @endif
                    <form action="{{ route('citas.cancelar', $cita->id) }}" method="POST" class="d-inline-block">
                        @csrf

                        <button class="btn btn-sm btn-danger" type="submit">
                            Cancelar
                        </button>
                    </form>
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
