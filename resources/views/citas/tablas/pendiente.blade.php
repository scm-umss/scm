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
                @endif
                <th scope="col">Sucursal</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas_pendientes as $cita)
                <tr>
                    <td>{{ $cita->fecha_programada }}</td>
                    <td>{{ $cita->hora_programada }}</td>
                    <td>{{ $cita->especialidad->nombre }}</td>
                    @if ($rol == 'paciente')
                        <td>{{ $cita->medico->nombreCompleto }}</td>
                    @elseif ($rol == 'medico')
                        <td>{{ $cita->paciente->nombre }}</td>
                    @endif
                    <td>{{ $cita->sucursal->nombre }}</td>
                    <td>
                        @if ($rol == 'admin')
                          <a class="btn btn-sm btn-primary" href="{{ route('citas.show', $cita->id) }}">
                              Ver
                          </a>
                          <a class="btn btn-sm btn-secondary" href="{{ route('citas.edit', $cita->id) }}">
                              Editar
                          </a>
                        @endif

                        @if ($rol == 'medico' || $rol == 'admin')
                          <form action="{{ route('citas.confirmar',$cita->id) }}"
                            method="POST" class="d-inline-block">
                            @csrf

                            <button class="btn btn-sm btn-success" type="submit">
                              Confirmar
                            </button>
                          </form>
                        @endif

                        <form action="{{ route('citas.cancelar', $cita->id) }}"
                          method="POST" class="d-inline-block">
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
    {{ $citas_pendientes->links() }}
</div>
