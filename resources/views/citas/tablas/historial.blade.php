@extends('citas.index')
@section('cabecera','Historial de citas')
@section('citas')
<div class="table-responsive">
    @if ($historial_citas->count())
    <table class="table table-striped">
        <thead>
            <tr>
                {{-- <th scope="col">Numero ficha</th> --}}
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Especialidad</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($historial_citas as $cita)
                <tr>
                    <td>{{ $cita->fecha_programada->format('d-m-Y') }}</td>
                    <td>{{ $cita->hora_programada }}</td>
                    <td>{{ $cita->especialidad->nombre }}</td>
                    @if ($cita->estado == 'Cancelada')
                    <td><span class="badge badge-danger">{{ $cita->estado }}</span></td>

                    @else
                    <td><span class="badge badge-success">{{ $cita->estado }}</span></td>
                    @endif
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('citas.show', $cita->id) }}">
                            Ver
                        </a>
                      </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $historial_citas->links() }}
    @else
        <p>Aun no tiene historial de citas</p>
    @endif
</div>
@endsection
