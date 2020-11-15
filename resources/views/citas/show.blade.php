@extends('layouts.app')

@section('content')
<div class="container ">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3 shadow">
                <div class="jumbotron">
                    <div class="container">
                        <h1 class="display-4">Detalle de citas</h1>
                        <p class="lead">Informe detallada de la cita #{{ $cita->id }}.</p>
                    </div>
                </div>
                <div class="px-5">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Cita del paciente:</strong> {{ $cita->paciente->nombreCompleto }}</h5>
                        <hr>
                        <p class="card-text"><strong>Fecha de la cita:</strong> {{ $cita->fecha_programada->format('d-m-Y') }} </p>
                        <p class="card-text"><strong>Hora de la cita:</strong> {{ $cita->hora_programada }} </p>
                        <p class="card-text"><strong>Estado:</strong>
                            @if($cita->estado == 'Cancelada')
                                <span class="badge badge-danger">{{ $cita->estado }}</span>
                            @elseif($cita->estado == 'Atendida')
                                <span class="badge badge-success">{{ $cita->estado }}</span>
                            @else
                                <span class="badge badge-warning">{{ $cita->estado }}</span>
                            @endif
                        </p>
                        <p class="card-text"><strong>Medico:</strong> {{ $cita->medico->nombreCompleto }}</p>
                        <p class="card-text"><strong>Especialidad:</strong> {{ $cita->especialidad->nombre }}</p>
                        <p class="card-text"><strong>Sucursal:</strong> {{ $cita->sucursal->nombre }}</p>
                        @if ($cita->estado == 'Cancelada')
                        <div class="alert alert-warning">
                            <h5><strong>Acerca de la cancelación</strong></h5>
                            <hr>
                            <p><strong>Fecha de cancelación:</strong> {{ $hCancelado->created_at->format('d-m-Y H:s') }}</p>
                            <p><strong>Cancelado por:</strong> {{ $hCancelado->user->nombreCompleto }}</p>
                            <p><strong>Justificación:</strong> {{ $hCancelado->descripcion }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="mb-4 text-center">
                    @if (($rol == 'medico' || $rol == 'admin') && ($cita->estado == 'Confirmada')
                        && ($cita->fecha_programada->format('Y-m-d') <= $fecha_actual))
                        <form action="{{ route('citas.atendido',$cita->id) }}"
                        method="POST" class="d-inline-block mr-2">
                        @csrf

                        <button class="btn btn-success" type="submit" dusk="atender-cita-{{ $cita->id }}">
                            Atendido
                        </button>
                        </form>
                    @endif
                    <a href="{{ url()->previous() }}" class="btn btn-danger">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
